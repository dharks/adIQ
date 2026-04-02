<?php $__env->startSection('title', 'Property — ' . (parse_url($site->url, PHP_URL_HOST) ?: $site->url)); ?>
<?php $__env->startSection('page-title', 'Property Detail'); ?>

<?php $__env->startSection('content'); ?>


<div class="breadcrumb">
    <a href="<?php echo e(route('dashboard')); ?>">Properties</a>
    <span class="breadcrumb-sep">›</span>
    <span style="color:var(--g700);"><?php echo e(parse_url($site->url, PHP_URL_HOST) ?: $site->url); ?></span>
</div>


<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
    <div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px;">
            <h2 style="font-size:18px;font-weight:700;color:var(--g900);"><?php echo e($site->url); ?></h2>
            <?php if($site->isSuspended()): ?>
                <span class="badge badge-red">Suspended</span>
            <?php elseif($site->activated): ?>
                <span class="badge badge-green">Licensed</span>
            <?php else: ?>
                <span class="badge badge-gray">Pending Activation</span>
            <?php endif; ?>
            <?php if($site->gam_connected): ?>
                <span class="badge badge-teal">GAM Connected</span>
            <?php endif; ?>
        </div>
        <p style="font-size:13px;color:var(--g500);">Registered <?php echo e($site->created_at->format('d M Y')); ?></p>
    </div>
</div>


<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Property Details</div>

        <div class="detail-row">
            <span class="detail-label">Domain</span>
            <span class="detail-value">
                <a href="<?php echo e($site->url); ?>" target="_blank" rel="noopener"
                   style="color:var(--g900);text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                    <?php echo e($site->url); ?>

                    <svg width="11" height="11" fill="none" stroke="var(--g400)" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                </a>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Access Key</span>
            <span class="detail-value">
                <button class="key-chip" id="key-detail"
                        onclick="var k=this;navigator.clipboard.writeText('<?php echo e($site->license_key); ?>').then(function(){var o=k.innerHTML;k.textContent='Copied!';setTimeout(function(){k.innerHTML=o},1500)})"
                        title="Click to copy full key" style="font-size:12px;padding:4px 10px;">
                    <code style="font-size:12px;font-family:monospace;letter-spacing:0.02em;"><?php echo e($site->license_key); ?></code>
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                </button>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">License Status</span>
            <span class="detail-value">
                <?php if($site->activated): ?>
                    <span class="badge badge-green">Active</span>
                    <?php if($site->domain): ?>
                        <span style="font-size:12px;color:var(--g500);margin-left:8px;">on <strong><?php echo e($site->domain); ?></strong></span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="badge badge-gray">Not Activated</span>
                    <span style="font-size:12px;color:var(--g500);margin-left:8px;">Install the plugin on WordPress to activate.</span>
                <?php endif; ?>
            </span>
        </div>

        <?php if($site->activated_at): ?>
        <div class="detail-row">
            <span class="detail-label">Activated</span>
            <span class="detail-value"><?php echo e($site->activated_at->format('d M Y, H:i')); ?></span>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="card" style="margin-bottom:0;">
        <div class="card-label">Inventory Source — Google Ad Manager</div>

        <?php if($site->gam_connected): ?>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value"><span class="badge badge-teal">Connected</span></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Account</span>
                <span class="detail-value"><?php echo e($site->gam_email ?: '—'); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Network</span>
                <span class="detail-value">
                    <?php if($site->gam_network_name): ?>
                        <?php echo e($site->gam_network_name); ?>

                        <?php if($site->gam_network_id): ?>
                            <span style="font-size:12px;color:var(--g400);margin-left:6px;">#<?php echo e($site->gam_network_id); ?></span>
                        <?php endif; ?>
                    <?php elseif($site->gam_network_id): ?>
                        Network #<?php echo e($site->gam_network_id); ?>

                    <?php else: ?>
                        —
                    <?php endif; ?>
                </span>
            </div>
        <?php else: ?>
            <div style="padding:24px 0;text-align:center;">
                <svg width="36" height="36" fill="none" stroke="var(--g300)" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                </svg>
                <p style="font-size:13px;color:var(--g500);margin-bottom:4px;font-weight:500;">No inventory source connected</p>
                <p style="font-size:12px;color:var(--g400);">Connect GAM from the adIQ plugin settings inside WordPress.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="card">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:4px;">
        <div>
            <div class="card-label" style="margin-bottom:2px;">Approved Origins</div>
            <p style="font-size:13px;color:var(--g500);margin-bottom:20px;">
                <?php if($site->domain): ?>
                    Root domain is <strong><?php echo e($site->domain); ?></strong>. Origins listed below are also authorised to use this access key
                    (e.g. <strong>staging.<?php echo e($site->domain); ?></strong>).
                <?php else: ?>
                    Root domain will appear here after the license is activated via the WordPress plugin.
                <?php endif; ?>
            </p>
        </div>
        <span style="font-size:12px;color:var(--g400);flex-shrink:0;margin-left:16px;">
            <?php echo e($subdomains->count()); ?>&thinsp;/&thinsp;5 used
        </span>
    </div>

    <?php if($subdomains->isNotEmpty()): ?>
    <div class="tbl-wrap" style="margin-bottom:24px;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Prefix</th>
                    <th>Full Origin</th>
                    <th>Added</th>
                    <th style="width:70px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $subdomains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><code style="font-size:12px;background:var(--g100);padding:2px 7px;border-radius:4px;border:1px solid var(--g200);"><?php echo e($sub->subdomain); ?></code></td>
                    <td style="color:var(--g500);font-size:13px;">
                        <?php if($site->domain): ?><?php echo e($sub->subdomain); ?>.<?php echo e($site->domain); ?><?php else: ?> —<?php endif; ?>
                    </td>
                    <td style="color:var(--g400);font-size:12px;"><?php echo e($sub->created_at->format('d M Y')); ?></td>
                    <td>
                        <form method="POST"
                              action="<?php echo e(route('sites.subdomains.delete', [$site, $sub->subdomain])); ?>"
                              onsubmit="return confirm('Remove <?php echo e($sub->subdomain); ?>? Sites on this origin will immediately lose access.')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-xs btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p style="color:var(--g400);font-size:13px;font-style:italic;margin-bottom:20px;">No additional origins approved yet.</p>
    <?php endif; ?>

    <?php if($remaining > 0): ?>
    <div style="border-top:1px solid var(--g100);padding-top:20px;">
        <div style="font-size:13px;font-weight:500;color:var(--g700);margin-bottom:12px;">Add an Origin</div>
        <form method="POST" action="<?php echo e(route('sites.subdomains.add', $site)); ?>">
            <?php echo csrf_field(); ?>
            <div style="display:flex;gap:10px;align-items:flex-start;flex-wrap:wrap;">
                <div>
                    <div style="display:flex;align-items:center;border:1.5px solid var(--g200);border-radius:7px;overflow:hidden;background:var(--g50);transition:border-color .15s;">
                        <input type="text" name="subdomain"
                               value="<?php echo e(old('subdomain')); ?>"
                               placeholder="e.g. staging"
                               maxlength="63"
                               style="border:none;outline:none;padding:9px 12px;font-size:13.5px;font-family:inherit;background:transparent;width:160px;color:var(--g900);">
                        <?php if($site->domain): ?>
                        <span style="padding:0 12px;background:var(--g100);color:var(--g500);font-size:12px;border-left:1px solid var(--g200);white-space:nowrap;">.<?php echo e($site->domain); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['subdomain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-err" style="margin-top:4px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="form-hint">Letters, numbers, and hyphens only.</p>
                </div>
                <button type="submit" class="btn btn-primary">Add Origin</button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div style="border-top:1px solid var(--g100);padding-top:16px;font-size:13px;color:var(--g500);">
        Origin limit reached (5 / 5). Remove one to add another.
    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/site-detail.blade.php ENDPATH**/ ?>