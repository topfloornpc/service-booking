<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Slot;
use Illuminate\Http\Request;

class AdminSlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with('service')->orderBy('start_at')->paginate(12);
        return view('admin.slots.index', compact('slots'));
    }

    public function create()
    {
        $services = Service::orderBy('title')->get();
        return view('admin.slots.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => ['required','exists:services,id'],
            'start_at' => ['required','date'],
            'end_at' => ['required','date','after:start_at'],
            'capacity' => ['required','integer','min:1','max:50'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Slot::create($data);

        return redirect()->route('admin.slots.index')->with('status', 'Slot created');
    }

    public function edit(Slot $slot)
    {
        $services = Service::orderBy('title')->get();
        return view('admin.slots.edit', compact('slot','services'));
    }

    public function update(Request $request, Slot $slot)
    {
        $data = $request->validate([
            'service_id' => ['required','exists:services,id'],
            'start_at' => ['required','date'],
            'end_at' => ['required','date','after:start_at'],
            'capacity' => ['required','integer','min:1','max:50'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $slot->update($data);

        return redirect()->route('admin.slots.index')->with('status', 'Slot updated');
    }

    public function destroy(Slot $slot)
    {
        $slot->delete();
        return back()->with('status', 'Slot deleted');
    }
}
