<x-app-layout>
    <x-slot name="header">
        @section('title', 'My Bookings | Booking Portal')
        @section('meta_description', 'View and manage your bookings.')

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My bookings
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-3">
                @forelse($bookings as $booking)
                    <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                {{ $booking->slot->service->title }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $booking->slot->start_at->format('d.m.Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                Status: {{ $booking->status }}
                                @if($booking->note) • Note: {{ $booking->note }} @endif
                            </div>
                        </div>

                        @if($booking->status === 'booked')
                            <form method="POST" action="{{ route('bookings.destroy', $booking) }}">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded bg-red-600 text-white">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="text-gray-600 dark:text-gray-300">No bookings yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
