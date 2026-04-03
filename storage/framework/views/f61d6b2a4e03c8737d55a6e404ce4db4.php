<?php $__env->startSection('title', 'Sign In'); ?>

<?php $__env->startSection('content'); ?>
<h1>Welcome back</h1>
<p class="auth-sub">Sign in to your adIQ publisher account.</p>

<form method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" class="form-input"
               value="<?php echo e(old('email')); ?>" required autofocus autocomplete="email"
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
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
            <label for="password" style="margin:0;">Password</label>
            <a href="<?php echo e(route('password.request')); ?>" style="font-size:12.5px;color:var(--teal);text-decoration:none;">Forgot password?</a>
        </div>
        <input type="password" id="password" name="password" class="form-input"
               required autocomplete="current-password" placeholder="Your password">
    </div>

    <div class="check-row" style="margin-bottom:24px;">
        <input type="checkbox" id="remember" name="remember" value="1">
        <label for="remember">Keep me signed in for 30 days</label>
    </div>

    <button type="submit" class="btn-auth">Sign In</button>
</form>

<p class="auth-switch">Don't have an account? <a href="<?php echo e(route('register')); ?>">Request access</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/auth/login.blade.php ENDPATH**/ ?>