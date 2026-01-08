<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
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
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Popular services</h1>
                <a href="<?php echo e(route('services.index')); ?>" class="text-sm underline text-gray-700 dark:text-gray-200">
                    View all
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('services.show', $service->slug)); ?>"
                       class="block rounded-lg border border-gray-200 dark:border-gray-800 p-4 hover:shadow">
                        <div class="flex items-start justify-between gap-2">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <?php echo e($service->title); ?>

                            </h2>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                €<?php echo e(number_format($service->price, 2)); ?>

                            </span>
                        </div>

                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                            <?php echo e($service->description ?? 'No description'); ?>

                        </p>

                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Duration: <?php echo e($service->duration_minutes); ?> min
                        </p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-gray-600 dark:text-gray-300">No services yet.</div>
                <?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Projects\booking-portal2\resources\views/home.blade.php ENDPATH**/ ?>