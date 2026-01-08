<x-app-layout>
    <x-slot name="header">
        @section('title', 'Services | Booking Portal')
        @section('meta_description', 'Browse available services and book a slot online.')

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Services
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}"
                       class="block rounded-lg border border-gray-200 dark:border-gray-800 p-4 hover:shadow">
                        <div class="flex items-start justify-between gap-2">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $service->title }}
                            </h2>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                €{{ number_format($service->price, 2) }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                            {{ $service->description ?? 'No description' }}
                        </p>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Duration: {{ $service->duration_minutes }} min
                        </p>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
