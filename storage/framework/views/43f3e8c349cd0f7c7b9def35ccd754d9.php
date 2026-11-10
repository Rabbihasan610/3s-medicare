<header class="top-header">
    <nav class="gap-3 navbar navbar-expand">
        <div class="mobile-toggle-icon fs-3">
            <i class="bi bi-list"></i>
        </div>
        <form class="searchbar">
            <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
            <input class="form-control navbar-search-field" type="text" placeholder="<?php echo app('translator')->get('Type here to search'); ?>">
            <div class="position-absolute top-50 translate-middle-y search-close-icon"><i class="bi bi-x-lg"></i></div>
            <ul class="search-list d-none"></ul>
        </form>
        <div class="top-navbar-right ms-auto">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item search-toggle-icon">
                    <a class="nav-link" href="#">
                        <div class="">
                            <i class="bi bi-search"></i>
                        </div>
                    </a>
                </li>

                <?php
                    $activeLangs = App\Models\Language::all();
                ?>
                <?php if(gs('multi_language') && $activeLangs->count() > 1): ?>
                    <li class="me-2">
                        <?php $__currentLoopData = $activeLangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(session('lang', config('app.locale')) != $langItem->code): ?>
                                <button class="px-3 btn btn-outline-info btn-sm radius-30 langSel" data-lang="<?php echo e($langItem->code); ?>">
                                    <i class="bi bi-translate"></i> <?php echo e(__($langItem->name)); ?>

                                </button>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </li>
                <?php endif; ?>



                <li class="me-2">
                    <a href="<?php echo e(url('/')); ?>" class="px-3 btn btn-outline-success btn-sm radius-30"
                        target="_blank"><i class="bi bi-globe"></i> <?php echo app('translator')->get('Visit Site'); ?></a>
                </li>
                <li class="me-2">
                    <a href="<?php echo e(url('clear')); ?>" class="px-3 btn btn-outline-dark btn-sm radius-30"><i
                            class="bi bi-arrow-clockwise"></i> <?php echo app('translator')->get('Cache Clear'); ?></a>
                </li>
                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown">
                        <div class="messages">
                            <span class="<?php echo e($adminNotificationCount > 0 ? 'notify-badge' : ''); ?>"></span>
                            <i class="bi bi-bell"></i>
                        </div>
                    </a>
                    <div class="p-0 dropdown-menu dropdown-menu-end">
                        <div class="p-2 m-2 border-bottom">
                            <h5 class="mb-0 h5"><?php echo app('translator')->get('Notifications'); ?></h5>
                            <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">
                                <?php if($adminNotificationCount > 0): ?>
                                    <?php echo app('translator')->get('You have'); ?> <?php echo e($adminNotificationCount); ?> <?php echo app('translator')->get('unread notification'); ?>
                                <?php else: ?>
                                    <?php echo app('translator')->get('No unread notification found'); ?>
                                <?php endif; ?>
                            </small>
                        </div>
                        <div class="p-2 header-notifications-list">
                            <?php $__currentLoopData = $adminNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item" href="<?php echo e(route('admin.notification.read', $notification->id)); ?>">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0 dropdown-msg-user"> <?php echo e(__($notification->title)); ?> </h6>
                                            <small
                                                class="mt-1 mb-0 dropdown-msg-text text-secondary d-flex align-items-center">
                                                <i class="bi bi-clock me-1"></i>
                                                <?php echo e($notification->created_at->diffForHumans()); ?>

                                            </small>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                        <div class="p-2">
                            <div>
                                <hr class="dropdown-divider">
                            </div>
                            <a class="dropdown-item" href="<?php echo e(route('admin.notifications')); ?>">
                                <div class="text-center"><?php echo app('translator')->get('View all notification'); ?></div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown dropdown-user-setting">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                        data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center">
                            <img src="https://via.placeholder.com/110X110" class="user-img" alt="">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <h6 class="mb-0 dropdown-user-name"><?php echo e(auth()->guard('admin')->user()->name); ?>

                                        </h6>
                                        <small
                                            class="mb-0 dropdown-user-designation text-secondary"><?php echo e(auth()->guard('admin')->user()->username); ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person"></i></div>
                                    <div class="ms-3"><span><?php echo app('translator')->get('Profile'); ?></span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.password')); ?>">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-key"></i></div>
                                    <div class="ms-3"><span><?php echo app('translator')->get('Passowrd'); ?></span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-box-arrow-right"></i></div>
                                    <div class="ms-3"><span><?php echo app('translator')->get('Logout'); ?></span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>

<?php $__env->startPush('script'); ?>
    <script>
        $(".langSel").on("click", function() {
            var langCode = $(this).data('lang');
            window.location.href = "<?php echo e(route('home')); ?>/change/" + langCode;
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/partials/topnav.blade.php ENDPATH**/ ?>