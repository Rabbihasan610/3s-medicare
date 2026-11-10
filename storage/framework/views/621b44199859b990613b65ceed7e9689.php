<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Question'); ?></th>
                                    <th><?php echo app('translator')->get('Lang'); ?></th>
                                    <th><?php echo app('translator')->get('Result'); ?></th>
                                    <th><?php echo app('translator')->get('Served'); ?></th>
                                    <th><?php echo app('translator')->get('Cost'); ?></th>
                                    <th><?php echo app('translator')->get('Feedback'); ?></th>
                                    <th><?php echo app('translator')->get('Asked'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $queries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $query): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td style="max-width:340px">
                                            <a href="<?php echo e(route('admin.assistant.queries.show', $query->id)); ?>">
                                                <?php echo e(str()->limit($query->query, 90)); ?>

                                            </a>
                                            <?php if($query->suggested_route): ?>
                                                <br><small class="text-muted">
                                                    <i class="bi bi-arrow-right-short"></i><?php echo e($query->suggested_route); ?>

                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-secondary text-uppercase"><?php echo e($query->lang); ?></span></td>
                                        <td><?php echo $query->statusBadge ?></td>
                                        <td>
                                            <?php echo $query->cacheBadge ?>
                                            <br><small class="text-muted"><?php echo e($query->latency_ms); ?> ms</small>
                                        </td>
                                        <td>
                                            <?php if($query->cost_usd > 0): ?>
                                                $<?php echo e(number_format($query->cost_usd, 5)); ?>

                                            <?php else: ?>
                                                <span class="text-muted">&mdash;</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($query->feedback === 1): ?>
                                                <i class="bi bi-hand-thumbs-up-fill text-success"></i>
                                            <?php elseif($query->feedback === 0): ?>
                                                <i class="bi bi-hand-thumbs-down-fill text-danger"></i>
                                            <?php else: ?>
                                                <span class="text-muted">&mdash;</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(diffForHumans($query->created_at)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.assistant.queries.show', $query->id)); ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($queries->hasPages()): ?>
                    <div class="card-footer pagination-card-footer">
                        <?php echo e(paginateLinks($queries)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    
    <form action="" method="GET" class="flex-wrap gap-2 d-flex">
        <div class="input-group w-auto flex-fill">
            <input type="search" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Search questions'); ?>"
                value="<?php echo e(request()->search); ?>">
            <button class="btn btn-primary" type="submit"><i class="la la-search"></i></button>
        </div>

        <select class="form-control w-auto" name="status" onchange="this.form.submit()">
            <option value=""><?php echo app('translator')->get('All results'); ?></option>
            <option value="ok" <?php if(request()->status === 'ok'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Answered'); ?></option>
            <option value="no_answer" <?php if(request()->status === 'no_answer'): echo 'selected'; endif; ?>><?php echo app('translator')->get('No answer'); ?></option>
            <option value="error" <?php if(request()->status === 'error'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Error'); ?></option>
        </select>

        <select class="form-control w-auto" name="lang" onchange="this.form.submit()">
            <option value=""><?php echo app('translator')->get('All languages'); ?></option>
            <option value="en" <?php if(request()->lang === 'en'): echo 'selected'; endif; ?>><?php echo app('translator')->get('English'); ?></option>
            <option value="ar" <?php if(request()->lang === 'ar'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Arabic'); ?></option>
        </select>

        <?php if (isset($component)) { $__componentOriginal00daea293777b493a0f7b779e8aa92fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal00daea293777b493a0f7b779e8aa92fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-date-field','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-date-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal00daea293777b493a0f7b779e8aa92fe)): ?>
<?php $attributes = $__attributesOriginal00daea293777b493a0f7b779e8aa92fe; ?>
<?php unset($__attributesOriginal00daea293777b493a0f7b779e8aa92fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal00daea293777b493a0f7b779e8aa92fe)): ?>
<?php $component = $__componentOriginal00daea293777b493a0f7b779e8aa92fe; ?>
<?php unset($__componentOriginal00daea293777b493a0f7b779e8aa92fe); ?>
<?php endif; ?>
    </form>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', ['title' => $pageTitle], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/assistant/queries/index.blade.php ENDPATH**/ ?>