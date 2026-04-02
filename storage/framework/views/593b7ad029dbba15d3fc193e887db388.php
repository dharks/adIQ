<?php $__env->startSection('title', 'Select GAM Network'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-card" style="max-width:520px">
    <h2>Select Your GAM Network</h2>
    <p style="font-size:14px;color:var(--g500);margin-bottom:20px">
        Authenticated as <strong><?php echo e($email); ?></strong>. Choose which Google Ad Manager network to connect to your site.
    </p>

    <?php if(empty($networks)): ?>
        <div class="alert alert-error">
            No GAM networks were found for this account. Make sure your Google account has access to at least one Ad Manager network.
        </div>
        <a href="<?php echo e($redirectUri); ?>" class="btn btn-outline btn-full" style="margin-top:8px">Go back to WordPress</a>
    <?php else: ?>
        <form method="POST" action="<?php echo e(route('gam.oauth.select-network')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="redirect_uri" value="<?php echo e($redirectUri); ?>">
            <input type="hidden" name="network_name" id="network_name" value="<?php echo e($networks[0]['displayName'] ?? ''); ?>">

            <div class="form-group">
                <label for="network_id">Ad Manager Network</label>
                <select name="network_id" id="network_id" style="width:100%;padding:10px 14px;border:1px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;background:#fff">
                    <?php $__currentLoopData = $networks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $network): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($network['networkCode'] ?? ''); ?>"
                                data-name="<?php echo e($network['displayName'] ?? $network['networkCode'] ?? ''); ?>">
                            <?php echo e($network['displayName'] ?? $network['networkCode'] ?? 'Unknown'); ?>

                            (<?php echo e($network['networkCode'] ?? ''); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Connect This Network</button>
        </form>
        <script>
            document.getElementById('network_id').addEventListener('change', function () {
                document.getElementById('network_name').value = this.selectedOptions[0].dataset.name;
            });
        </script>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/oauth/select-network.blade.php ENDPATH**/ ?>