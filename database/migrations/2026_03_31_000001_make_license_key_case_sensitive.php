<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * MySQL's default utf8/utf8mb4 collation is case-insensitive, which means
     * byLicenseKey() can match a row even if the case differs from what the
     * plugin stored. This causes HMAC verification to fail because both sides
     * use different byte representations of the same conceptual key.
     *
     * Changing to utf8mb4_bin makes the column binary/case-sensitive.
     */
    public function up(): void
    {
        DB::statement(
            'ALTER TABLE sites MODIFY license_key VARCHAR(32)
             CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL'
        );
    }

    public function down(): void
    {
        DB::statement(
            'ALTER TABLE sites MODIFY license_key VARCHAR(32)
             CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL'
        );
    }
};
