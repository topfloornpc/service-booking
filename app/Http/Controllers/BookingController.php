<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Slot;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('slot.service')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slot_id' => ['required','exists:slots,id'],
            'note' => ['nullable','string','max:255'],
        ]);

        $slot = Slot::where('id', $data['slot_id'])
            ->where('is_active', true)
            ->where('start_at', '>=', now())
            ->firstOrFail();

        $currentBooked = Booking::where('slot_id', $slot->id)->where('status','booked')->count();
        if ($currentBooked >= $slot->capacity) {
            return back()->withErrors(['slot_id' => 'This slot is already full.']);
        }

        Booking::create([
            'user_id' => auth()->id(),
            'slot_id' => $slot->id,
            'status' => 'booked',
            'note' => $data['note'] ?? null,
        ]);

        return redirect()->route('bookings.index');
    }

    public function destroy(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);
        $booking->update(['status' => 'cancelled']);
        return back();
    }
}
