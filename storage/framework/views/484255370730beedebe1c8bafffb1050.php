<?php $__env->startSection('title', 'Publisher Console'); ?>
<?php $__env->startSection('page-title', 'Publisher Console'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-error"><?php echo e(session('error')); ?></div>
<?php endif; ?>


<div class="stat-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card">
        <div class="stat-label">Total Publishers</div>
        <div class="stat-value"><?php echo e(number_format($totalSites)); ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active Licenses</div>
        <div class="stat-value" style="color:var(--green)"><?php echo e(number_format($activeSites)); ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">GAM Connected</div>
        <div class="stat-value" style="color:var(--teal)">
            
            <?php $gamCount = \App\Models\Site::where('gam_connected', true)->count(); ?>
            <?php echo e(number_format($gamCount)); ?>

        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Suspended</div>
        <div class="stat-value" style="color:var(--red)"><?php echo e(number_format($suspendedSites)); ?></div>
    </div>
</div>


<div class="search-bar">
    <form method="GET" action="<?php echo e(route('admin.index')); ?>" style="display:flex;gap:10px;flex:1;">
        <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Search by domain, access key, or publisher email…"
               class="form-input" style="flex:1;max-width:480px;">
        <button type="submit" class="btn btn-primary btn-sm">Search</button>
        <?php if($search): ?>
            <a href="<?php echo e(route('admin.index')); ?>" class="btn btn-outline btn-sm">Clear</a>
        <?php endif; ?>
    </form>
</div>


<div class="tbl-wrap">
    <?php if($sites->isEmpty()): ?>
        <div class="empty-state">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <p><?php echo e($search ? 'No publishers found matching "' . e($search) . '".' : 'No publishers yet.'); ?></p>
        </div>
    <?php else: ?>
    <table class="tbl">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Publisher</th>
                <th>Access Key</th>
                <th>License</th>
                <th>GAM</th>
                <th>Registered</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                    title="<?php echo e($site->url ?: $site->activated_url); ?>">
                    <span style="font-weight:500;color:var(--g900);">
                        <?php echo e(parse_url($site->url ?: $site->activated_url, PHP_URL_HOST) ?: ($site->url ?: '—')); ?>

                    </span>
                </td>
                <td style="font-size:12.5px;color:var(--g500);">
                    <?php echo e($site->user?->email ?? '—'); ?>

                </td>
                <td>
                    <button class="key-chip"
                            title="<?php echo e($site->license_key); ?>"
                            onclick="var btn=this;navigator.clipboard.writeText('<?php echo e($site->license_key); ?>').then(function(){var o=btn.innerHTML;btn.textContent='Copied!';setTimeout(function(){btn.innerHTML=o},1200)})">
                        <?php echo e(substr($site->license_key, 0, 8)); ?>&hellip;
                        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                    </button>
                </td>
                <td>
                    <?php if($site->isSuspended()): ?>
                        <span class="badge badge-red">Suspended</span>
                    <?php elseif($site->activated_at): ?>
                        <span class="badge badge-green">Active</span>
                    <?php else: ?>
                        <span class="badge badge-gray">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($site->gam_connected): ?>
                        <span class="badge badge-teal" title="<?php echo e($site->gam_email); ?>">Connected</span>
                    <?php else: ?>
                        <span class="badge badge-gray">—</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:12px;color:var(--g400);white-space:nowrap;">
                    <?php echo e($site->created_at->format('d M Y')); ?>

                </td>
                <td>
                    <div style="display:flex;gap:5px;align-items:center;white-space:nowrap;">
                        <a href="<?php echo e(route('admin.sites.show', $site)); ?>" class="btn btn-xs btn-outline">View</a>

                        <form method="POST" action="<?php echo e(route('admin.sites.suspend', $site)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="btn btn-xs <?php echo e($site->isSuspended() ? 'btn-primary' : ''); ?>"
                                    style="<?php echo e($site->isSuspended() ? '' : 'background:#fff;border-color:#FCD34D;color:var(--amber-txt);'); ?>"
                                    onclick="return confirm('<?php echo e($site->isSuspended() ? 'Unsuspend this publisher?' : 'Suspend this publisher? Their license will stop working immediately.'); ?>')">
                                <?php echo e($site->isSuspended() ? 'Reinstate' : 'Suspend'); ?>

                            </button>
                        </form>

                        <form method="POST" action="<?php echo e(route('admin.sites.destroy', $site)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-xs btn-danger"
                                    onclick="return confirm('Permanently delete this publisher and all data? This cannot be undone.')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?php if($sites->hasPages()): ?>
    <div class="pagination">
        <?php if($sites->onFirstPage()): ?>
            <span class="pg-disabled">&laquo; Prev</span>
        <?php else: ?>
            <a href="<?php echo e($sites->previousPageUrl()); ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php $__currentLoopData = $sites->getUrlRange(max(1, $sites->currentPage()-3), min($sites->lastPage(), $sites->currentPage()+3)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($page == $sites->currentPage()): ?>
                <span class="pg-active"><?php echo e($page); ?></span>
            <?php else: ?>
                <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($sites->hasMorePages()): ?>
            <a href="<?php echo e($sites->nextPageUrl()); ?>">Next &raquo;</a>
        <?php else: ?>
            <span class="pg-disabled">Next &raquo;</span>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/admin/index.blade.php ENDPATH**/ ?>