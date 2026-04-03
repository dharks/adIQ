<?php $__env->startSection('title', 'Terms of Service — adIQ by Percivo'); ?>
<?php $__env->startSection('meta-description', 'Terms of Service for adIQ by Percivo. The terms governing your use of the adIQ platform and WordPress plugin.'); ?>

<?php $__env->startPush('head-styles'); ?>
<style>
    .legal-wrap {
        max-width: 760px;
        margin: 0 auto;
        padding: 72px 24px 96px;
    }

    .legal-wrap h1 {
        font-size: 32px;
        font-weight: 800;
        color: var(--g900);
        letter-spacing: -0.8px;
        margin-bottom: 8px;
    }

    .legal-meta {
        font-size: 13px;
        color: var(--g400);
        margin-bottom: 48px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--g200);
    }

    .legal-wrap h2 {
        font-size: 17px;
        font-weight: 700;
        color: var(--g900);
        margin: 36px 0 10px;
    }

    .legal-wrap p,
    .legal-wrap li {
        font-size: 15px;
        color: var(--g700);
        line-height: 1.75;
        margin-bottom: 14px;
    }

    .legal-wrap ul {
        padding-left: 20px;
        margin-bottom: 14px;
    }

    .legal-wrap a {
        color: var(--teal);
        text-decoration: none;
    }

    .legal-wrap a:hover {
        text-decoration: underline;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="legal-wrap">
    <h1>Terms of Service</h1>
    <p class="legal-meta">Last updated: April 2025 &nbsp;·&nbsp; Percivo / adIQ by Percivo</p>

    <p>These Terms of Service ("Terms") govern your access to and use of adIQ by Percivo, including the adIQ WordPress plugin, the web platform at <a href="<?php echo e(route('home')); ?>">adiq.percivo.io</a>, and related services (collectively, the "Service"), provided by Percivo ("we", "us", or "our").</p>
    <p>By creating an account or using the Service, you agree to these Terms. If you do not agree, do not use the Service.</p>

    <h2>1. Use of the Service</h2>
    <p>You may use the Service only for lawful purposes and in accordance with these Terms. You agree not to:</p>
    <ul>
        <li>Use the Service to violate any applicable law or regulation.</li>
        <li>Attempt to reverse-engineer, decompile, or extract source code from the Service.</li>
        <li>Share, transfer, or resell licence keys issued to your account.</li>
        <li>Use the Service in a way that damages, disables, or impairs its operation or security.</li>
        <li>Use the Service to serve ads that violate Google's ad policies or any applicable advertising regulations.</li>
    </ul>

    <h2>2. Accounts</h2>
    <p>You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. You must notify us immediately of any unauthorised use of your account.</p>
    <p>We reserve the right to suspend or terminate accounts that violate these Terms or that are used for fraudulent activity.</p>

    <h2>3. Licence Keys and Plugin Access</h2>
    <p>Each registered WordPress site is issued a unique licence key. Licence keys are non-transferable and are tied to the domain registered at the time of activation. Use of a licence key on an unauthorised domain constitutes a breach of these Terms.</p>
    <p>You may add approved subdomains (up to the limit shown in your account) to extend access to staging or development environments.</p>

    <h2>4. Google Ad Manager Integration</h2>
    <p>The Service includes an OAuth integration with Google Ad Manager. By connecting your Google account, you authorise us to access your GAM account data on your behalf solely to provide the adIQ service. Your use of Google Ad Manager is separately governed by Google's Terms of Service.</p>
    <p>We are not affiliated with or endorsed by Google. Any issues with your Google Ad Manager account or ad serving should be directed to Google.</p>

    <h2>5. Intellectual Property</h2>
    <p>The adIQ platform, including its software, design, and documentation, is owned by Percivo and protected by intellectual property laws. Nothing in these Terms grants you any right to use our trademarks, logos, or brand assets without prior written consent.</p>
    <p>The adIQ WordPress plugin is distributed under the GPL-2.0 licence. The plugin source code is subject to the terms of that licence.</p>

    <h2>6. Availability and Modifications</h2>
    <p>We aim to maintain high availability of the Service but do not guarantee uninterrupted access. We reserve the right to modify, suspend, or discontinue any part of the Service at any time, with reasonable notice where practicable.</p>

    <h2>7. Disclaimer of Warranties</h2>
    <p>The Service is provided "as is" and "as available" without warranties of any kind, express or implied. We do not warrant that the Service will be error-free, uninterrupted, or that ad revenue outcomes will meet your expectations.</p>

    <h2>8. Limitation of Liability</h2>
    <p>To the maximum extent permitted by applicable law, Percivo shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of or inability to use the Service, including loss of revenue, data, or goodwill.</p>

    <h2>9. Termination</h2>
    <p>You may terminate your account at any time by contacting us. We may terminate or suspend your access to the Service immediately, without notice, for conduct that we determine violates these Terms or is harmful to other users, us, or third parties.</p>

    <h2>10. Changes to These Terms</h2>
    <p>We may update these Terms from time to time. Continued use of the Service after changes are posted constitutes acceptance of the revised Terms. We will notify you of material changes via the platform or by email.</p>

    <h2>11. Governing Law</h2>
    <p>These Terms are governed by and construed in accordance with applicable law. Any disputes arising under these Terms shall be subject to the exclusive jurisdiction of the relevant courts.</p>

    <h2>12. Contact</h2>
    <p>For questions about these Terms, contact us at <a href="mailto:legal@percivo.io">legal@percivo.io</a> or visit <a href="https://percivo.io" target="_blank" rel="noopener">percivo.io</a>.</p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/dharks/Documents/web-projects/adiq-site/resources/views/terms.blade.php ENDPATH**/ ?>