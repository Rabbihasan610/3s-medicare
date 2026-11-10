<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="btn-group flex-wrap gap-1" role="group">
                            <a href="<?php echo e(route('admin.quote_request.index')); ?>" class="btn btn-sm <?php echo e(!request('status') || request('status') == 'all' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                <?php echo app('translator')->get('All'); ?>
                            </a>
                            <a href="<?php echo e(route('admin.quote_request.index', ['status' => 'pending'])); ?>" class="btn btn-sm <?php echo e(request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning'); ?>">
                                <?php echo app('translator')->get('Pending'); ?> <?php if(@$pendingCount): ?> <span class="badge bg-danger"><?php echo e($pendingCount); ?></span> <?php endif; ?>
                            </a>
                            <a href="<?php echo e(route('admin.quote_request.index', ['status' => 'contacted'])); ?>" class="btn btn-sm <?php echo e(request('status') == 'contacted' ? 'btn-info' : 'btn-outline-info'); ?>">
                                <?php echo app('translator')->get('Contacted'); ?>
                            </a>
                            <a href="<?php echo e(route('admin.quote_request.index', ['status' => 'completed'])); ?>" class="btn btn-sm <?php echo e(request('status') == 'completed' ? 'btn-success' : 'btn-outline-success'); ?>">
                                <?php echo app('translator')->get('Completed'); ?>
                            </a>
                            <a href="<?php echo e(route('admin.quote_request.index', ['status' => 'rejected'])); ?>" class="btn btn-sm <?php echo e(request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger'); ?>">
                                <?php echo app('translator')->get('Rejected'); ?>
                            </a>
                        </div>

                        <form action="<?php echo e(route('admin.quote_request.index')); ?>" method="GET" class="d-flex gap-2">
                            <?php if(request('status')): ?>
                                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                            <?php endif; ?>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="<?php echo app('translator')->get('Search name, email, phone...'); ?>" value="<?php echo e(request('search')); ?>">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead class="table-light">
                                <tr>
                                    <th><?php echo app('translator')->get('Client Name'); ?></th>
                                    <th><?php echo app('translator')->get('Contact'); ?></th>
                                    <th><?php echo app('translator')->get('Practice Type'); ?></th>
                                    <th><?php echo app('translator')->get('Services'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Submitted At'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?php echo e($quote->name); ?></span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div><i class="bi bi-envelope text-muted"></i> <?php echo e($quote->email); ?></div>
                                                <?php if($quote->phone): ?>
                                                    <div><i class="bi bi-telephone text-muted"></i> <?php echo e($quote->phone); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e($quote->category ?: ($quote->client_type ?: __('General'))); ?></span>
                                        </td>
                                        <td>
                                            <?php if($quote->services && is_array($quote->services)): ?>
                                                <?php $__currentLoopData = array_slice($quote->services, 0, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-light text-dark border"><?php echo e($s); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(count($quote->services) > 2): ?>
                                                    <span class="badge bg-light text-muted border">+<?php echo e(count($quote->services) - 2); ?></span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($quote->status == 'pending'): ?>
                                                <span class="badge bg-warning text-dark"><?php echo app('translator')->get('Pending'); ?></span>
                                            <?php elseif($quote->status == 'contacted'): ?>
                                                <span class="badge bg-info"><?php echo app('translator')->get('Contacted'); ?></span>
                                            <?php elseif($quote->status == 'completed'): ?>
                                                <span class="badge bg-success"><?php echo app('translator')->get('Completed'); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?php echo app('translator')->get('Rejected'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($quote->created_at)); ?><br>
                                            <small class="text-muted"><?php echo e(diffForHumans($quote->created_at)); ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="<?php echo e(route('admin.quote_request.detail', $quote->id)); ?>" class="dropdown-item">
                                                            <i class="la la-eye text-primary"></i> <?php echo app('translator')->get('View Details'); ?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-action="<?php echo e(route('admin.quote_request.delete', $quote->id)); ?>"
                                                            data-question="<?php echo app('translator')->get('Are you sure to remove this quote request?'); ?>">
                                                            <i class="la la-trash text-danger"></i> <?php echo app('translator')->get('Delete'); ?>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%"><?php echo app('translator')->get('No quote requests found'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($quotes->hasPages()): ?>
                    <div class="card-footer pagination-card-footer">
                        <?php echo e(paginateLinks($quotes)); ?>

                    </div>
                <?php endif; ?>
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


<?php echo $__env->make('admin.layouts.app', ['title' => $pageTitle], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/quote_requests/index.blade.php ENDPATH**/ ?>