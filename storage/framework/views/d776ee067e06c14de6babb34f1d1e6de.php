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

    <div class="form-group">
        <label for="password_confirmation">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
               required autocomplete="new-password" placeholder="Repeat password">
    </div>

    
    <div style="border-top:1px solid var(--g200);margin:20px 0 18px;padding-top:18px;">
        <p style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:var(--g400);margin-bottom:14px;">Location details</p>

        <div class="form-group">
            <label for="country">Country <span style="color:var(--red)">*</span></label>
            <select id="country" name="country" required
                    style="width:100%;padding:11px 14px;border:1.5px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;color:var(--g900);background:var(--g50);transition:border-color .15s,box-shadow .15s;appearance:none;-webkit-appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;">
                <option value="">Select country...</option>
            </select>
            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="state">State / Province</label>
            <select id="state" name="state"
                    style="width:100%;padding:11px 14px;border:1.5px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;color:var(--g900);background:var(--g50);transition:border-color .15s,box-shadow .15s;appearance:none;-webkit-appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;">
                <option value="">Select state...</option>
            </select>
            <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <select id="city" name="city"
                    style="width:100%;padding:11px 14px;border:1.5px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;color:var(--g900);background:var(--g50);transition:border-color .15s,box-shadow .15s;appearance:none;-webkit-appearance:none;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 14px center;">
                <option value="">Select city...</option>
            </select>
            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="address">Street address</label>
            <input type="text" id="address" name="address"
                   value="<?php echo e(old('address')); ?>" autocomplete="street-address"
                   placeholder="123 Main St, Suite 4"
                   style="width:100%;padding:11px 14px;border:1.5px solid var(--g200);border-radius:8px;font-size:14px;font-family:inherit;color:var(--g900);background:var(--g50);transition:border-color .15s,box-shadow .15s;">
            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-err"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
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

<script>
(function () {
    // Cascading country → state → city using countriesnow.space API
    const countryEl = document.getElementById('country');
    const stateEl   = document.getElementById('state');
    const cityEl    = document.getElementById('city');

    const oldCountry = <?php echo json_encode(old('country', ''), 512) ?>;
    const oldState   = <?php echo json_encode(old('state', ''), 512) ?>;
    const oldCity    = <?php echo json_encode(old('city', ''), 512) ?>;

    function setSelectDisabled(el, disabled) {
        el.disabled = disabled;
        el.style.opacity = disabled ? '0.5' : '1';
        el.style.cursor  = disabled ? 'not-allowed' : 'default';
    }

    function populateSelect(el, items, placeholder, selectedValue) {
        el.innerHTML = `<option value="">${placeholder}</option>`;
        items.forEach(function (item) {
            const opt = document.createElement('option');
            opt.value = item;
            opt.textContent = item;
            if (item === selectedValue) opt.selected = true;
            el.appendChild(opt);
        });
    }

    // Load countries on page load
    fetch('https://countriesnow.space/api/v0.1/countries/positions')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (!data.data) return;
            const names = data.data.map(function (c) { return c.name; }).sort();
            populateSelect(countryEl, names, 'Select country...', oldCountry);
            setSelectDisabled(countryEl, false);
            if (oldCountry) loadStates(oldCountry);
        })
        .catch(function () { /* silently fail — user can type manually */ });

    function loadStates(country) {
        setSelectDisabled(stateEl, true);
        setSelectDisabled(cityEl, true);
        stateEl.innerHTML = '<option value="">Loading...</option>';
        cityEl.innerHTML  = '<option value="">Select city...</option>';

        fetch('https://countriesnow.space/api/v0.1/countries/states', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: country }),
        })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                const states = (data.data && data.data.states)
                    ? data.data.states.map(function (s) { return s.name; }).sort()
                    : [];
                if (states.length > 0) {
                    populateSelect(stateEl, states, 'Select state...', oldState);
                    setSelectDisabled(stateEl, false);
                    if (oldState) loadCities(country, oldState);
                } else {
                    stateEl.innerHTML = '<option value="">Not applicable</option>';
                    setSelectDisabled(stateEl, false);
                }
            })
            .catch(function () {
                stateEl.innerHTML = '<option value="">Select state...</option>';
                setSelectDisabled(stateEl, false);
            });
    }

    function loadCities(country, state) {
        setSelectDisabled(cityEl, true);
        cityEl.innerHTML = '<option value="">Loading...</option>';

        fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country: country, state: state }),
        })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                const cities = (data.data && Array.isArray(data.data))
                    ? data.data.sort()
                    : [];
                if (cities.length > 0) {
                    populateSelect(cityEl, cities, 'Select city...', oldCity);
                } else {
                    cityEl.innerHTML = '<option value="">Select city...</option>';
                }
                setSelectDisabled(cityEl, false);
            })
            .catch(function () {
                cityEl.innerHTML = '<option value="">Select city...</option>';
                setSelectDisabled(cityEl, false);
            });
    }

    countryEl.addEventListener('change', function () {
        stateEl.innerHTML  = '<option value="">Select state...</option>';
        cityEl.innerHTML   = '<option value="">Select city...</option>';
        if (this.value) loadStates(this.value);
    });

    stateEl.addEventListener('change', function () {
        cityEl.innerHTML = '<option value="">Select city...</option>';
        if (this.value && countryEl.value) loadCities(countryEl.value, this.value);
    });

    // Style focus on selects
    [countryEl, stateEl, cityEl].forEach(function (el) {
        el.addEventListener('focus', function () {
            this.style.borderColor = 'var(--teal)';
            this.style.boxShadow   = '0 0 0 3px rgba(45,189,181,.12)';
            this.style.background  = '#fff';
        });
        el.addEventListener('blur', function () {
            this.style.borderColor = 'var(--g200)';
            this.style.boxShadow   = 'none';
            this.style.background  = 'var(--g50)';
        });
    });
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/auth/register.blade.php ENDPATH**/ ?>