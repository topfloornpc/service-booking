@php
    use Illuminate\Support\Str;
    $pageTitle = $service->title . ' | Booking Portal';
    $pageDescription = Str::limit($service->description ?? 'Book a service slot online.', 150);
@endphp

<x-app-layout>
    <x-slot name="header">
        @section('title', $pageTitle)
        @section('meta_description', $pageDescription)

        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $service->title }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                €{{ number_format($service->price, 2) }} • {{ $service->duration_minutes }} min
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                <p class="text-gray-700 dark:text-gray-200">
                    {{ $service->description ?? 'No description provided.' }}
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Available slots</h3>

                @if($errors->any())
                    <div class="mb-3 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="space-y-3">
                    @forelse($slots as $slot)
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $slot->start_at->format('d.m.Y H:i') }} — {{ $slot->end_at->format('H:i') }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    Capacity: {{ $slot->capacity }}
                                </div>
                            </div>

                            @auth
                                <form method="POST" action="{{ route('bookings.store') }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                    <input name="note" placeholder="Note (optional)"
                                           class="w-full sm:w-56 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" />
                                    <button class="px-3 py-2 rounded bg-gray-900 text-white dark:bg-gray-100 dark:text-black">
                                        Book
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm underline text-gray-700 dark:text-gray-200">
                                    Login to book
                                </a>
                            @endauth
                        </div>
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">No slots available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
