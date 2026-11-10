<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.partials.topnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('admin.partials.sidenav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    <main class="page-content">
        <!--breadcrumb-->
        <div class="mb-4 page-breadcrumb d-sm-flex align-items-center justify-content-between">
            <div class="mb-2 breadcrumb-title mb-sm-0"><?php echo e(__(@$title)); ?></div>
           <div>
                <?php echo $__env->yieldPushContent('breadcrumb-plugins'); ?>
           </div>
        </div>
        <!--end breadcrumb-->

        <?php echo $__env->yieldContent('panel'); ?>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>