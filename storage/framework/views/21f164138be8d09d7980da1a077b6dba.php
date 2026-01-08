<?php
    use Illuminate\Support\Str;
    $pageTitle = $service->title . ' | Booking Portal';
    $pageDescription = Str::limit($service->description ?? 'Book a service slot online.', 150);
?>

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
        <?php $__env->startSection('title', $pageTitle); ?>
        <?php $__env->startSection('meta_description', $pageDescription); ?>

        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <?php echo e($service->title); ?>

            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                €<?php echo e(number_format($service->price, 2)); ?> • <?php echo e($service->duration_minutes); ?> min
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                <p class="text-gray-700 dark:text-gray-200">
                    <?php echo e($service->description ?? 'No description provided.'); ?>

                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Available slots</h3>

                <?php if($errors->any()): ?>
                    <div class="mb-3 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-800 p-4">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e($slot->start_at->format('d.m.Y H:i')); ?> — <?php echo e($slot->end_at->format('H:i')); ?>

                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    Capacity: <?php echo e($slot->capacity); ?>

                                </div>
                            </div>

                            <?php if(auth()->guard()->check()): ?>
                                <form method="POST" action="<?php echo e(route('bookings.store')); ?>" class="flex items-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="slot_id" value="<?php echo e($slot->id); ?>">
                                    <input name="note" placeholder="Note (optional)"
                                           class="w-full sm:w-56 rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" />
                                    <button class="px-3 py-2 rounded bg-gray-900 text-white dark:bg-gray-100 dark:text-black">
                                        Book
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="text-sm underline text-gray-700 dark:text-gray-200">
                                    Login to book
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-gray-600 dark:text-gray-300">No slots available.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\Projects\booking-portal2\resources\views/services/show.blade.php ENDPATH**/ ?>