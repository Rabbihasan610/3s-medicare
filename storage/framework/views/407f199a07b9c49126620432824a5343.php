<?php $__env->startSection('panel'); ?>
    <div class="row gy-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card b-radius--10 mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle text-primary me-2"></i><?php echo e($quote->name); ?>

                    </h5>
                    <?php if($quote->status == 'pending'): ?>
                        <span class="badge bg-warning text-dark px-3 py-2"><?php echo app('translator')->get('Pending'); ?></span>
                    <?php elseif($quote->status == 'contacted'): ?>
                        <span class="badge bg-info px-3 py-2"><?php echo app('translator')->get('Contacted'); ?></span>
                    <?php elseif($quote->status == 'completed'): ?>
                        <span class="badge bg-success px-3 py-2"><?php echo app('translator')->get('Completed'); ?></span>
                    <?php else: ?>
                        <span class="badge bg-danger px-3 py-2"><?php echo app('translator')->get('Rejected'); ?></span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="text-muted small"><?php echo app('translator')->get('Email Address'); ?></label>
                            <p class="fw-bold mb-0">
                                <a href="mailto:<?php echo e($quote->email); ?>" class="text-decoration-none">
                                    <i class="bi bi-envelope me-1"></i><?php echo e($quote->email); ?>

                                </a>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small"><?php echo app('translator')->get('Phone Number'); ?></label>
                            <p class="fw-bold mb-0">
                                <?php if($quote->phone): ?>
                                    <a href="tel:<?php echo e($quote->phone); ?>" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i><?php echo e($quote->phone); ?>

                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo app('translator')->get('Not provided'); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small"><?php echo app('translator')->get('Healthcare Practice Type'); ?></label>
                            <p class="fw-bold mb-0">
                                <span class="badge bg-primary px-2 py-1"><?php echo e($quote->category ?: ($quote->client_type ?: __('General Practice'))); ?></span>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small"><?php echo app('translator')->get('Submitted On'); ?></label>
                            <p class="fw-bold mb-0">
                                <?php echo e(showDateTime($quote->created_at, 'd M, Y - h:i A')); ?>

                                <small class="text-muted">(<?php echo e(diffForHumans($quote->created_at)); ?>)</small>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small d-block mb-2"><?php echo app('translator')->get('Services of Interest'); ?></label>
                        <div>
                            <?php if($quote->services && is_array($quote->services)): ?>
                                <?php $__currentLoopData = $quote->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-light text-dark border px-3 py-2 me-1 mb-1 fs-6">
                                        <i class="bi bi-check2-circle text-primary me-1"></i><?php echo e($service); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted"><?php echo app('translator')->get('No specific service checked'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small d-block mb-2"><?php echo app('translator')->get('Client Message & Requirements'); ?></label>
                        <div class="p-3 bg-light rounded border" style="white-space: pre-wrap; font-size: 0.95rem; line-height: 1.6;">
                            <?php echo e($quote->message); ?>

                        </div>
                    </div>

                    <?php if($quote->ip_address): ?>
                        <div class="text-muted small pt-2">
                            <i class="bi bi-shield-check me-1"></i><?php echo app('translator')->get('Sender IP'); ?>: <code><?php echo e($quote->ip_address); ?></code>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card b-radius--10">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><?php echo app('translator')->get('Manage Lead'); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.quote_request.update', $quote->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold"><?php echo app('translator')->get('Lead Status'); ?></label>
                            <select name="status" class="form-select">
                                <option value="pending" <?php echo e($quote->status == 'pending' ? 'selected' : ''); ?>><?php echo app('translator')->get('Pending'); ?></option>
                                <option value="contacted" <?php echo e($quote->status == 'contacted' ? 'selected' : ''); ?>><?php echo app('translator')->get('Contacted'); ?></option>
                                <option value="completed" <?php echo e($quote->status == 'completed' ? 'selected' : ''); ?>><?php echo app('translator')->get('Completed'); ?></option>
                                <option value="rejected" <?php echo e($quote->status == 'rejected' ? 'selected' : ''); ?>><?php echo app('translator')->get('Rejected'); ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold"><?php echo app('translator')->get('Internal Admin Notes'); ?></label>
                            <textarea name="admin_notes" class="form-control" rows="5" placeholder="<?php echo app('translator')->get('Add internal team notes, follow-up dates, call summaries...'); ?>"><?php echo e($quote->admin_notes); ?></textarea>
                            <small class="text-muted"><?php echo app('translator')->get('Visible only to admin team.'); ?></small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check2-circle me-1"></i><?php echo app('translator')->get('Update Status & Notes'); ?>
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-white border-top">
                    <button class="btn btn-outline-danger w-100 confirmationBtn"
                        data-action="<?php echo e(route('admin.quote_request.delete', $quote->id)); ?>"
                        data-question="<?php echo app('translator')->get('Are you sure to delete this lead record permanently?'); ?>">
                        <i class="la la-trash"></i> <?php echo app('translator')->get('Delete Quote Request'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirmation-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $attributes = $__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__attributesOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c)): ?>
<?php $component = $__componentOriginal5b8b2d0f151a30be878e1a760ec3900c; ?>
<?php unset($__componentOriginal5b8b2d0f151a30be878e1a760ec3900c); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('admin.quote_request.index')); ?>" class="btn btn-sm btn-outline-primary">
        <i class="la la-arrow-left"></i> <?php echo app('translator')->get('Back to All Requests'); ?>
    </a>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('admin.layouts.app', ['title' => $pageTitle], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/quote_requests/detail.blade.php ENDPATH**/ ?>