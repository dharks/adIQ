<?php $__env->startSection('title', 'Create Account'); ?>

<?php $__env->startSection('content'); ?>
<h1>Create your account</h1>
<p class="auth-sub">Get access to adIQ publisher tools and GAM integration.</p>

<form method="POST" action="<?php echo e(route('register')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" id="name" name="name" class="form-input"
               value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name"
               placeholder="Jane Smith">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="email">Work email</label>
        <input type="email" id="email" name="email" class="form-input"
               value="<?php echo e(old('email')); ?>" required autocomplete="email"
               placeholder="you@company.com">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input"
               required minlength="8" autocomplete="new-password"
               placeholder="Minimum 8 characters">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group" style="margin-bottom:24px;">
        <label for="password_confirmation">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
               required autocomplete="new-password" placeholder="Repeat password">
    </div>

    <div style="margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" name="terms" id="terms" value="1"
                   style="width:16px;height:16px;flex-shrink:0;accent-color:var(--teal);cursor:pointer;"
                   <?php echo e(old('terms') ? 'checked' : ''); ?>>
            <label for="terms" style="margin:0;font-size:13.5px;font-weight:400;color:var(--g500);cursor:pointer;line-height:1.4;">
                I agree to the <a href="<?php echo e(route('terms')); ?>" target="_blank" rel="noopener" style="color:var(--teal);text-decoration:none;">Terms of Service</a> and <a href="<?php echo e(route('privacy')); ?>" target="_blank" rel="noopener" style="color:var(--teal);text-decoration:none;">Privacy Policy</a>
            </label>
        </div>
        <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err" style="margin-top:6px;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <button type="submit" class="btn-auth">Create Account</button>
</form>

<p class="auth-switch">Already have an account? <a href="<?php echo e(route('login')); ?>">Sign in</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/auth/register.blade.php ENDPATH**/ ?>