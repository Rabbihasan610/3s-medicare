<?php
    /*
    | Badge counts come from a single cached query (App\Lib\SidebarCounter) shared
    | by the view composer in AppServiceProvider, so nothing here queries the
    | database. $sidebarCounts is keyed by the slugs that class defines.
    */
    $counts = $sidebarCounts ?? [];
    $count = fn($key) => (int) ($counts[$key] ?? 0);
?>

<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="d-flex align-items-center">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="d-inline-flex align-items-center">
                <img src="<?php echo e(siteLogo()); ?>"
                    alt="<?php echo e(__(gs('site_name'))); ?>" style="max-height: 38px; width: auto; max-width: 175px; object-fit: contain;">
            </a>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bi bi-list"></i>
        </div>
    </div>

    <ul class="metismenu sidebar__menu-main" id="menu">

        
        <li class="sidebar--menu <?php echo e(menuActive('admin.dashboard')); ?>">
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <div class="parent-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Dashboard'); ?></div>
            </a>
        </li>

        
        <li class="menu-label"><?php echo app('translator')->get('Requests'); ?></li>

        <li class="sidebar--menu <?php echo e(menuActive('admin.quote_request*')); ?>">
            <a href="<?php echo e(route('admin.quote_request.index')); ?>">
                <div class="parent-icon"><i class="bi bi-chat-square-quote"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Quote Requests'); ?></div>
                <?php if($count('quote_request')): ?>
                    <span class="badge bg-danger rounded-pill ms-auto"><?php echo e($count('quote_request')); ?></span>
                <?php endif; ?>
            </a>
        </li>

        
        <li class="menu-label"><?php echo app('translator')->get('Catalogue'); ?></li>

        <li class="sidebar--menu <?php echo e(menuActive('admin.service*')); ?>">
            <a href="<?php echo e(route('admin.service.index')); ?>">
                <div class="parent-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Services Catalog'); ?></div>
            </a>
        </li>

        <li class="sidebar--menu <?php echo e(menuActive('admin.project*')); ?>">
            <a href="<?php echo e(route('admin.project.index')); ?>">
                <div class="parent-icon"><i class="bi bi-briefcase"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Case Studies / Work'); ?></div>
            </a>
        </li>

        

        
        <li class="menu-label"><?php echo app('translator')->get('Content'); ?></li>

        <li class="sidebar--menu <?php echo e(menuActive(['admin.frontend.manage.pages*', 'admin.frontend.manage.section*'])); ?>">
            <a href="<?php echo e(route('admin.frontend.manage.pages')); ?>">
                <div class="parent-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Manage Pages'); ?></div>
            </a>
        </li>

        <li class="sidebar--menu sidebar--dropdown <?php echo e(menuActive('admin.frontend.sections*')); ?>">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-layout-text-window-reverse"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Manage Section'); ?></div>
            </a>
            <ul>
                <?php
                    $lastSegment = collect(request()->segments())->last();
                ?>
                <?php $__currentLoopData = getPageSections(true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $secs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($secs['builder']): ?>
                        <li class="<?php echo e($lastSegment == $k ? 'mm-active' : ''); ?>">
                            <a href="<?php echo e(route('admin.frontend.sections', $k)); ?>">
                                <i class="bi bi-square"></i><?php echo e(__($secs['name'])); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </li>

        
        

        <li class="sidebar--menu <?php echo e(menuActive('admin.subscriber*')); ?>">
            <a href="<?php echo e(route('admin.subscriber.index')); ?>">
                <div class="parent-icon"><i class="bi bi-envelope-paper"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Subscribers'); ?></div>
            </a>
        </li>

        <li class="sidebar--menu sidebar--dropdown <?php echo e(menuActive('admin.support*')); ?>">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-headset"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Customer Support'); ?></div>
                <?php if($pendingSupportCount): ?>
                    <span class="red__notify"></span>
                <?php endif; ?>
            </a>
            <ul>
                <li class="<?php echo e(menuActive('admin.support.pending')); ?>">
                    <a href="<?php echo e(route('admin.support.pending')); ?>">
                        <i class="bi bi-hourglass-split"></i><?php echo app('translator')->get('Pending Support'); ?>
                        <?php if($pendingSupportCount): ?>
                            <span class="badge bg-danger rounded-pill ms-auto"><?php echo e($pendingSupportCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.support.answered')); ?>">
                    <a href="<?php echo e(route('admin.support.answered')); ?>">
                        <i class="bi bi-reply"></i><?php echo app('translator')->get('Answered Support'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.support.closed')); ?>">
                    <a href="<?php echo e(route('admin.support.closed')); ?>">
                        <i class="bi bi-archive"></i><?php echo app('translator')->get('Closed Support'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.support.index')); ?>">
                    <a href="<?php echo e(route('admin.support.index')); ?>">
                        <i class="bi bi-inboxes"></i><?php echo app('translator')->get('All Support'); ?>
                    </a>
                </li>
            </ul>
        </li>


        
        <li class="menu-label"><?php echo app('translator')->get('AI Help Center'); ?></li>

        <li
            class="sidebar--menu sidebar--dropdown <?php echo e(menuActive(['admin.assistant.insights', 'admin.assistant.queries*', 'admin.assistant.conversations*', 'admin.assistant.providers*', 'admin.assistant.knowledge*'])); ?>">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-chat-dots"></i></div>
                <div class="menu-title"><?php echo e(__('Assistant')); ?></div>
                <?php if($count('assistant_attention')): ?>
                    <span class="red__notify"></span>
                <?php endif; ?>
            </a>
            <ul>
                <li class="<?php echo e(menuActive('admin.assistant.insights')); ?>">
                    <a href="<?php echo e(route('admin.assistant.insights')); ?>">
                        <i class="bi bi-graph-up"></i><?php echo app('translator')->get('Insights'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.assistant.queries.index')); ?>">
                    <a href="<?php echo e(route('admin.assistant.queries.index')); ?>">
                        <i class="bi bi-question-circle"></i><?php echo app('translator')->get('Visitor Questions'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.assistant.conversations*')); ?>">
                    <a href="<?php echo e(route('admin.assistant.conversations.index')); ?>">
                        <i class="bi bi-chat-left-text"></i><?php echo app('translator')->get('Conversations'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.assistant.queries.unanswered')); ?>">
                    <a href="<?php echo e(route('admin.assistant.queries.unanswered')); ?>">
                        <i class="bi bi-patch-exclamation"></i><?php echo app('translator')->get('Content Gaps'); ?>
                        <?php if($count('assistant_unanswered')): ?>
                            <span
                                class="badge bg-danger rounded-pill ms-auto"><?php echo e($count('assistant_unanswered')); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.assistant.knowledge')); ?>">
                    <a href="<?php echo e(route('admin.assistant.knowledge')); ?>">
                        <i class="bi bi-database"></i><?php echo app('translator')->get('Knowledge Base'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.assistant.providers*')); ?>">
                    <a href="<?php echo e(route('admin.assistant.providers.index')); ?>">
                        <i class="bi bi-cpu"></i><?php echo app('translator')->get('AI Providers'); ?>
                    </a>
                </li>
            </ul>
        </li>

        
        <li class="menu-label"><?php echo app('translator')->get('System'); ?></li>

        <li class="sidebar--menu sidebar--dropdown <?php echo e(menuActive('admin.report*')); ?>">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Report'); ?></div>
            </a>
            <ul>
                <li class="<?php echo e(menuActive('admin.report.login.history')); ?>">
                    <a href="<?php echo e(route('admin.report.login.history')); ?>">
                        <i class="bi bi-box-arrow-in-right"></i><?php echo app('translator')->get('Login History'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.report.notification.history')); ?>">
                    <a href="<?php echo e(route('admin.report.notification.history')); ?>">
                        <i class="bi bi-bell-fill"></i><?php echo app('translator')->get('Notification History'); ?>
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar--menu sidebar--dropdown <?php echo e(menuActive('admin.setting.notification*')); ?>">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-bell"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Notification Setting'); ?></div>
            </a>
            <ul>
                <li class="<?php echo e(menuActive('admin.setting.notification.global')); ?>">
                    <a href="<?php echo e(route('admin.setting.notification.global')); ?>">
                        <i class="bi bi-layout-wtf"></i><?php echo app('translator')->get('Global Template'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.notification.templates')); ?>">
                    <a href="<?php echo e(route('admin.setting.notification.templates')); ?>">
                        <i class="bi bi-files"></i><?php echo app('translator')->get('Notification Templates'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.notification.email')); ?>">
                    <a href="<?php echo e(route('admin.setting.notification.email')); ?>">
                        <i class="bi bi-envelope-at"></i><?php echo app('translator')->get('System Email'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.notification.sms')); ?>">
                    <a href="<?php echo e(route('admin.setting.notification.sms')); ?>">
                        <i class="bi bi-chat-dots"></i><?php echo app('translator')->get('SMS Setting'); ?>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="sidebar--menu sidebar--dropdown <?php echo e(menuActive(['admin.setting.index', 'admin.setting.system*', 'admin.setting.cookie', 'admin.setting.logo.icon', 'admin.setting.custom.css', 'admin.extensions*', 'admin.language*', 'admin.seo', 'admin.setting.sitemap', 'admin.setting.robots', 'admin.maintenance.mode'])); ?>">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-gear"></i></div>
                <div class="menu-title"><?php echo app('translator')->get('Settings'); ?></div>
            </a>
            <ul>
                <li class="<?php echo e(menuActive('admin.setting.index')); ?>">
                    <a href="<?php echo e(route('admin.setting.index')); ?>">
                        <i class="bi bi-sliders"></i><?php echo app('translator')->get('General Setting'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.system.configuration')); ?>">
                    <a href="<?php echo e(route('admin.setting.system.configuration')); ?>">
                        <i class="bi bi-toggles"></i><?php echo app('translator')->get('System Configuration'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.logo.icon')); ?>">
                    <a href="<?php echo e(route('admin.setting.logo.icon')); ?>">
                        <i class="bi bi-image"></i><?php echo e(__('Logo & Favicon')); ?>

                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.seo')); ?>">
                    <a href="<?php echo e(route('admin.seo')); ?>">
                        <i class="bi bi-search"></i><?php echo e(__('SEO & Verification')); ?>

                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.sitemap')); ?>">
                    <a href="<?php echo e(route('admin.setting.sitemap')); ?>">
                        <i class="bi bi-diagram-3"></i><?php echo e(__('Sitemap Manager')); ?>

                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.robots')); ?>">
                    <a href="<?php echo e(route('admin.setting.robots')); ?>">
                        <i class="bi bi-robot"></i><?php echo e(__('Robots.txt')); ?>

                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.extensions*')); ?>">
                    <a href="<?php echo e(route('admin.extensions.index')); ?>">
                        <i class="bi bi-puzzle"></i><?php echo app('translator')->get('Extensions'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.language*')); ?>">
                    <a href="<?php echo e(route('admin.language.manage')); ?>">
                        <i class="bi bi-translate"></i><?php echo app('translator')->get('Language'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.maintenance.mode')); ?>">
                    <a href="<?php echo e(route('admin.maintenance.mode')); ?>">
                        <i class="bi bi-cone-striped"></i><?php echo app('translator')->get('Maintenance Mode'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.cookie')); ?>">
                    <a href="<?php echo e(route('admin.setting.cookie')); ?>">
                        <i class="bi bi-shield-check"></i><?php echo app('translator')->get('GDPR Cookie'); ?>
                    </a>
                </li>
                <li class="<?php echo e(menuActive('admin.setting.custom.css')); ?>">
                    <a href="<?php echo e(route('admin.setting.custom.css')); ?>">
                        <i class="bi bi-code-slash"></i><?php echo app('translator')->get('Custom CSS'); ?>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
<?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/partials/sidenav.blade.php ENDPATH**/ ?>