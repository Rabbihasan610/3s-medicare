<?php
    $kpi = $stats['kpi'];
    $byType = collect($stats['byType']);
    $trend = $stats['trend'];
    $people = $stats['people'];
?>

<?php $__env->startPush('style'); ?>
    <style>
        .dash-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .dash-kpi {
            display: block;
            color: inherit;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .dash-kpi:hover {
            color: inherit;
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .08);
        }

        .dash-kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dash-kpi-value {
            font-size: 1.85rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .badge-pending {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-reviewed {
            background-color: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }

        .badge-contacted {
            background-color: #d1fae5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .dash-quick-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.88rem;
            transition: all 0.18s ease;
        }

        .dash-quick-link:hover {
            background: #081C36;
            color: #ffffff;
            border-color: #081C36;
            transform: translateX(3px);
        }

        .dash-quick-link:hover i.action-arrow {
            transform: translateX(4px);
            color: #19b5a5 !important;
        }

        .dash-chart {
            position: relative;
            height: 250px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('panel'); ?>

    
    <div class="row mb-4">
        <div class="col-12">
            <div class="dash-card p-4 position-relative overflow-hidden" style="background: radial-gradient(800px 300px at 90% 0%, rgba(25, 181, 165, 0.15), transparent 70%), #081C36; color: #ffffff;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge rounded-pill px-3 py-1 bg-white bg-opacity-10 text-white border border-white border-opacity-20" style="font-size: 0.76rem; letter-spacing: 0.05em;">
                                <i class="bi bi-shield-check text-success me-1"></i> <?php echo e(__('3S MEDI CARE DIGITAL HUB')); ?>

                            </span>
                            <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.72rem;"><?php echo e(__('System Online')); ?></span>
                        </div>
                        <h3 class="fw-bold text-white mb-1">
                            <?php echo e(__('Welcome,')); ?> <?php echo e(auth('admin')->user()->name); ?>

                        </h3>
                        <p class="text-white text-opacity-75 small mb-0">
                            <?php echo e(__('Overview of your healthcare client quote requests, website content, and digital inquiries.')); ?>

                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm">
                            <i class="bi bi-box-arrow-up-right"></i> <?php echo e(__('View Public Website')); ?>

                        </a>
                        <a href="<?php echo e(route('admin.quote_request.index')); ?>" class="btn btn-sm rounded-pill px-3 py-2 text-white fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background: #19b5a5;">
                            <i class="bi bi-inbox-fill"></i> <?php echo e(__('All Quotes')); ?> (<?php echo e($quoteCounts['total']); ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="<?php echo e(route('admin.quote_request.index')); ?>?status=pending" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #fee2e2; color: #dc2626;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block"><?php echo e(__('Pending Quotes')); ?></span>
                        <div class="dash-kpi-value text-dark"><?php echo e($quoteCounts['pending']); ?></div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="<?php echo e($quoteCounts['pending'] > 0 ? 'text-danger fw-semibold' : 'text-muted'); ?>">
                        <i class="bi <?php echo e($quoteCounts['pending'] > 0 ? 'bi-exclamation-circle' : 'bi-check2'); ?> me-1"></i>
                        <?php echo e($quoteCounts['pending'] > 0 ? __('Needs response') : __('All responded')); ?>

                    </small>
                    <span class="small text-primary fw-medium"><?php echo e(__('View list')); ?> &rarr;</span>
                </div>
            </a>
        </div>

        
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="<?php echo e(route('admin.quote_request.index')); ?>" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #e0f2fe; color: #0284c7;">
                        <i class="bi bi-calculator-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block"><?php echo e(__('Total Quotes')); ?></span>
                        <div class="dash-kpi-value text-dark"><?php echo e($quoteCounts['total']); ?></div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="text-muted"><?php echo e(__('Contacted')); ?>: <strong class="text-success"><?php echo e($quoteCounts['contacted']); ?></strong></small>
                    <small class="text-muted"><?php echo e(__('Reviewed')); ?>: <strong class="text-warning"><?php echo e($quoteCounts['reviewed']); ?></strong></small>
                </div>
            </a>
        </div>

        
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="<?php echo e(url('services')); ?>" target="_blank" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #ccfbf1; color: #0d9488;">
                        <i class="bi bi-hospital-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block"><?php echo e(__('Offered Services')); ?></span>
                        <div class="dash-kpi-value text-dark"><?php echo e($servicesCount); ?></div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="text-muted"><i class="bi bi-check-circle text-success me-1"></i><?php echo e(__('Active on Website')); ?></small>
                    <span class="small text-primary fw-medium"><?php echo e(__('Preview')); ?> &rarr;</span>
                </div>
            </a>
        </div>

        
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="<?php echo e(route('admin.assistant.queries.index')); ?>" class="dash-card dash-kpi text-decoration-none h-100 p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="dash-kpi-icon" style="background: #f3e8ff; color: #9333ea;">
                        <i class="bi bi-chat-heart-fill"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block"><?php echo e(__('AI & Search Queries')); ?></span>
                        <div class="dash-kpi-value text-dark"><?php echo e($assistantQueriesCount); ?></div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <small class="text-muted"><?php echo e(__('Subscribers')); ?>: <strong class="text-dark"><?php echo e($subscribersCount); ?></strong></small>
                    <span class="small text-primary fw-medium"><?php echo e(__('Insights')); ?> &rarr;</span>
                </div>
            </a>
        </div>
    </div>

    
    <div class="row g-4">
        
        <div class="col-12 col-xl-8">
            
            <div class="dash-card mb-4 overflow-hidden">
                <div class="p-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-white">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history text-primary"></i>
                            <?php echo e(__('Recent Healthcare Quote Requests')); ?>

                        </h6>
                        <small class="text-muted"><?php echo e(__('Latest practice leads submitted via /get-quote & contact forms')); ?></small>
                    </div>
                    <a href="<?php echo e(route('admin.quote_request.index')); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <?php echo e(__('View All Quotes')); ?> &rarr;
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-secondary small">
                                <th class="ps-4"><?php echo e(__('Client / Practice')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Contact Phone')); ?></th>
                                <th><?php echo e(__('Requested Services')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th class="pe-4 text-end"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $latestQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?php echo e($quote->name); ?></div>
                                        <small class="text-muted"><?php echo e($quote->email ?: __('No email provided')); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border small">
                                            <?php echo e($quote->client_type ?: __('General')); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="tel:<?php echo e($quote->phone); ?>" class="text-dark fw-semibold text-decoration-none">
                                            <i class="bi bi-telephone text-primary me-1"></i><?php echo e($quote->phone); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php if(!empty($quote->services) && is_array($quote->services)): ?>
                                            <div class="d-flex flex-wrap gap-1" style="max-width: 220px;">
                                                <?php $__currentLoopData = array_slice($quote->services, 0, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-secondary-subtle text-secondary small py-0 px-2" style="font-size: 0.72rem;"><?php echo e($s); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(count($quote->services) > 2): ?>
                                                    <span class="badge bg-light text-muted small py-0 px-1">+<?php echo e(count($quote->services) - 2); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted small">&mdash;</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($quote->status == 'pending'): ?>
                                            <span class="badge badge-pending px-2 py-1 rounded-pill small"><?php echo e(__('Pending')); ?></span>
                                        <?php elseif($quote->status == 'reviewed'): ?>
                                            <span class="badge badge-reviewed px-2 py-1 rounded-pill small"><?php echo e(__('Reviewed')); ?></span>
                                        <?php elseif($quote->status == 'contacted'): ?>
                                            <span class="badge badge-contacted px-2 py-1 rounded-pill small"><?php echo e(__('Contacted')); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark border small"><?php echo e(ucfirst($quote->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="<?php echo e(route('admin.quote_request.detail', $quote->id)); ?>" class="btn btn-sm btn-primary rounded-pill px-3 py-1">
                                            <i class="bi bi-eye me-1"></i><?php echo e(__('Details')); ?>

                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                        <strong><?php echo e(__('No quote requests yet')); ?></strong>
                                        <p class="small text-muted mb-0"><?php echo e(__('Quote submissions from prospective clinics will appear here.')); ?></p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="dash-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo e(__('Quote & Request Activity Trend')); ?></h6>
                        <small class="text-muted"><?php echo e(__('Daily inquiry traffic over the last 30 days')); ?></small>
                    </div>
                    <span class="badge bg-light text-secondary border small"><?php echo e(__('30 Days')); ?></span>
                </div>
                <div class="dash-chart">
                    <canvas id="requestTrendChart"></canvas>
                </div>
            </div>
        </div>

        
        <div class="col-12 col-xl-4">
            
            <div class="dash-card p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    <?php echo e(__('Quick Management Actions')); ?>

                </h6>

                <div class="d-flex flex-column gap-2">
                    <a href="<?php echo e(route('admin.quote_request.index')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-calculator text-primary"></i>
                            <?php echo e(__('Quote Requests')); ?>

                        </span>
                        <?php if($quoteCounts['pending'] > 0): ?>
                            <span class="badge bg-danger rounded-pill"><?php echo e($quoteCounts['pending']); ?></span>
                        <?php else: ?>
                            <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                        <?php endif; ?>
                    </a>

                    <a href="<?php echo e(route('admin.setting.logo.icon')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-image text-info"></i>
                            <?php echo e(__('Logo & Favicon Setting')); ?>

                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="<?php echo e(route('admin.setting.sitemap')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-diagram-3 text-success"></i>
                            <?php echo e(__('XML Sitemap Manager')); ?>

                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="<?php echo e(route('admin.setting.robots')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-robot text-dark"></i>
                            <?php echo e(__('Robots.txt Editor')); ?>

                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="<?php echo e(route('admin.frontend.sections', 'seo')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-google text-danger"></i>
                            <?php echo e(__('SEO & Verification')); ?>

                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="<?php echo e(route('admin.frontend.sections', 'footer')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-layout-text-window-reverse text-secondary"></i>
                            <?php echo e(__('Footer Settings & Info')); ?>

                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>

                    <a href="<?php echo e(route('admin.assistant.queries.index')); ?>" class="dash-quick-link">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-chat-heart text-purple" style="color: #9333ea;"></i>
                            <?php echo e(__('AI Assistant Inquiries')); ?>

                        </span>
                        <i class="bi bi-chevron-right action-arrow text-muted small"></i>
                    </a>
                </div>
            </div>

            
            <div class="dash-card p-4">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-cpu text-primary"></i>
                    <?php echo e(__('Healthcare Platform Health')); ?>

                </h6>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><?php echo e(__('Newsletter Subscribers')); ?></span>
                        <span class="fw-bold text-dark"><?php echo e($subscribersCount); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><?php echo e(__('Support Tickets')); ?></span>
                        <span class="fw-bold text-dark"><?php echo e($stats['people']['support'] ?? 0); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><?php echo e(__('Framework Version')); ?></span>
                        <span class="badge bg-light text-dark border">Laravel <?php echo e(app()->version()); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><?php echo e(__('PHP Environment')); ?></span>
                        <span class="badge bg-light text-dark border">PHP <?php echo e(PHP_VERSION); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                        <span class="text-muted"><?php echo e(__('Agency Brand')); ?></span>
                        <strong class="text-primary"><?php echo e(gs('site_name')); ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/admin/js/chart.js')); ?>"></script>
    <script>
        'use strict';

        var trendCtx = document.getElementById('requestTrendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode(array_keys($trend), 15, 512) ?>,
                    datasets: [{
                        label: <?php echo json_encode(__('Quote Requests'), 15, 512) ?>,
                        data: <?php echo json_encode(array_values($trend), 15, 512) ?>,
                        borderColor: '#19b5a5',
                        backgroundColor: 'rgba(25, 181, 165, 0.12)',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#081C36',
                        fill: true,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', ['title' => 'Healthcare Dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>