<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Booking Portal
            </h2>

            <div class="flex items-center gap-2">
                <input id="cityInput" class="w-40 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                       placeholder="City (e.g. Riga)" />
                <button id="weatherBtn" class="px-3 py-2 rounded bg-gray-900 text-white dark:bg-gray-100 dark:text-black">
                    Weather
                </button>
            </div>
        </div>
        <p id="weatherBox" class="mt-2 text-sm text-gray-600 dark:text-gray-300">Weather: —</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Popular services</h1>
                <a href="{{ route('services.index') }}" class="text-sm underline text-gray-700 dark:text-gray-200">
                    View all
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($services as $service)
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
                @empty
                    <div class="text-gray-600 dark:text-gray-300">No services yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        async function loadWeather() {
            const city = document.getElementById('cityInput').value || 'Riga';
            const box = document.getElementById('weatherBox');
            box.textContent = 'Weather: loading...';

            try {
                const res = await fetch(`/api/weather?city=${encodeURIComponent(city)}`);
                const data = await res.json();
                box.textContent = `Weather in ${data.city}: ${data.temp ?? '—'}°C, ${data.desc ?? ''}`;
            } catch (e) {
                box.textContent = 'Weather: failed to load';
            }
        }
        document.getElementById('weatherBtn').addEventListener('click', loadWeather);
        loadWeather();
    </script>
</x-app-layout>
