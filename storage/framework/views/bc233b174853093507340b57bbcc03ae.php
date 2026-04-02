<?php $__env->startSection('title', 'Admin — Site Detail'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .back-link{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--g500);text-decoration:none;margin-bottom:20px}
    .back-link:hover{color:var(--g900)}
    .page-title{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:gap}
    .page-title h1{font-size:20px;font-weight:700;word-break:break-all}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
    .detail-card{background:#fff;border:1px solid var(--g200);border-radius:12px;padding:22px}
    .detail-card h3{font-size:13px;font-weight:600;color:var(--g500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:14px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-row:last-child{margin-bottom:0}
    .detail-label{font-size:11px;font-weight:600;color:var(--g500);text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px}
    .detail-value{font-size:14px;color:var(--g900);word-break:break-all}
    .lk-full{font-size:12px;background:var(--g100);padding:4px 8px;border-radius:4px;color:var(--indigo);font-family:monospace;cursor:pointer;border:none;word-break:break-all;display:inline-block}
    .subdomain-list{list-style:none;padding:0;margin:0}
    .subdomain-list li{font-size:13px;padding:4px 0;border-bottom:1px solid var(--g100);color:var(--g700)}
    .subdomain-list li:last-child{border-bottom:none}
    .badge-red{background:#fee2e2;color:var(--red)}
    .suspend-actions{display:flex;align-items:center;gap:10px;margin-top:6px}
    .note-area{width:100%;min-height:100px;padding:10px 14px;border:1px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;resize:vertical}
    .note-area:focus{border-color:var(--indigo);outline:none;box-shadow:0 0 0 3px rgba(99,102,241,.1)}
    .danger-zone{background:#fff;border:1px solid #fecaca;border-radius:12px;padding:22px;margin-top:20px}
    .danger-zone h3{font-size:13px;font-weight:600;color:var(--red);text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px}
    .danger-zone p{font-size:13px;color:var(--g500);margin-bottom:14px}
    @media(max-width:700px){.detail-grid{grid-template-columns:1fr}}
</style>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-error"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<a href="<?php echo e(route('admin.index')); ?>" class="back-link">&#8592; Back to All Sites</a>

<div class="page-title">
    <h1><?php echo e($site->url ?: ($site->activated_url ?: 'Unactivated Site')); ?></h1>
    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0">
        <?php if($site->isSuspended()): ?>
            <span class="badge badge-red" style="font-size:13px;padding:4px 12px">Suspended</span>
        <?php elseif($site->activated_at): ?>
            <span class="badge badge-green" style="font-size:13px;padding:4px 12px">Active</span>
        <?php else: ?>
            <span class="badge badge-gray" style="font-size:13px;padding:4px 12px">Inactive</span>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.sites.suspend', $site)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit"
                    class="btn btn-sm <?php echo e($site->isSuspended() ? 'btn-primary' : 'btn-outline'); ?>"
                    style="<?php echo e($site->isSuspended() ? '' : 'border-color:#fbbf24;color:#92400e'); ?>"
                    onclick="return confirm('<?php echo e($site->isSuspended() ? 'Unsuspend this site?' : 'Suspend this site?'); ?>')">
                <?php echo e($site->isSuspended() ? 'Unsuspend' : 'Suspend'); ?>

            </button>
        </form>
    </div>
</div>

<div class="detail-grid">
    
    <div class="detail-card">
        <h3>Site Details</h3>

        <div class="detail-row">
            <span class="detail-label">Site URL</span>
            <span class="detail-value"><?php echo e($site->url ?: '—'); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Activated URL</span>
            <span class="detail-value"><?php echo e($site->activated_url ?: '—'); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">License Key</span>
            <button class="lk-full"
                    title="Click to copy"
                    onclick="navigator.clipboard.writeText('<?php echo e($site->license_key); ?>');this.textContent='Copied!';setTimeout(()=>this.textContent='<?php echo e($site->license_key); ?>',1500)">
                <?php echo e($site->license_key); ?>

            </button>
        </div>

        <div class="detail-row">
            <span class="detail-label">Activation Date</span>
            <span class="detail-value">
                <?php echo e($site->activated_at ? $site->activated_at->format('d M Y, H:i') : '—'); ?>

            </span>
        </div>

        <?php if($site->isSuspended()): ?>
        <div class="detail-row">
            <span class="detail-label">Suspended At</span>
            <span class="detail-value" style="color:var(--red)">
                <?php echo e($site->suspended_at->format('d M Y, H:i')); ?>

            </span>
        </div>
        <?php endif; ?>

        <div class="detail-row">
            <span class="detail-label">Created</span>
            <span class="detail-value"><?php echo e($site->created_at->format('d M Y, H:i')); ?></span>
        </div>
    </div>

    
    <div class="detail-card">
        <h3>Account Owner</h3>

        <?php if($site->user): ?>
            <div class="detail-row">
                <span class="detail-label">Name</span>
                <span class="detail-value"><?php echo e($site->user->name); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value"><?php echo e($site->user->email); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Member Since</span>
                <span class="detail-value"><?php echo e($site->user->created_at->format('d M Y')); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Sites</span>
                <span class="detail-value"><?php echo e($site->user->sites()->count()); ?></span>
            </div>
        <?php else: ?>
            <p style="font-size:14px;color:var(--g500)">No user associated.</p>
        <?php endif; ?>
    </div>

    
    <div class="detail-card">
        <h3>Google Ad Manager</h3>

        <?php if($site->gam_connected): ?>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="badge badge-blue">Connected</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Account Email</span>
                <span class="detail-value"><?php echo e($site->gam_email ?: '—'); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Network ID</span>
                <span class="detail-value"><?php echo e($site->gam_network_id ?: '—'); ?></span>
            </div>
            <?php if($site->gamToken): ?>
                <div class="detail-row">
                    <span class="detail-label">Token Expiry</span>
                    <span class="detail-value">
                        <?php if($site->gamToken->expires_at ?? null): ?>
                            <?php echo e(\Carbon\Carbon::parse($site->gamToken->expires_at)->format('d M Y, H:i')); ?>

                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="badge badge-gray">Not Connected</span>
            </div>
            <p style="font-size:13px;color:var(--g500);margin-top:8px">This site has not connected a Google Ad Manager account.</p>
        <?php endif; ?>
    </div>

    
    <div class="detail-card">
        <h3>Allowed Subdomains</h3>

        <?php if($site->allowedSubdomains->isNotEmpty()): ?>
            <ul class="subdomain-list">
                <?php $__currentLoopData = $site->allowedSubdomains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subdomain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($subdomain->subdomain); ?><span style="color:var(--g500)">.<?php echo e($site->domain); ?></span></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p style="font-size:13px;color:var(--g500)">No subdomains registered.</p>
        <?php endif; ?>

        <?php if($site->domain): ?>
            <div style="margin-top:12px;font-size:12px;color:var(--g500)">
                Root domain: <strong><?php echo e($site->domain); ?></strong>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="detail-card" style="margin-bottom:20px">
    <h3>Admin Note</h3>
    <form method="POST" action="<?php echo e(route('admin.sites.note', $site)); ?>">
        <?php echo csrf_field(); ?>
        <textarea name="admin_note" class="note-area" placeholder="Internal note — only visible to admins…"><?php echo e(old('admin_note', $site->admin_note)); ?></textarea>
        <div style="margin-top:10px">
            <button type="submit" class="btn btn-sm btn-primary">Save Note</button>
        </div>
    </form>
</div>


<div class="danger-zone">
    <h3>Danger Zone</h3>
    <p>Permanently delete this site, its GAM token, and all subdomain records. This action cannot be undone.</p>
    <form method="POST" action="<?php echo e(route('admin.sites.destroy', $site)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Permanently delete this site and all related data? This CANNOT be undone.')">
            Delete Site Permanently
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/admin/show.blade.php ENDPATH**/ ?>