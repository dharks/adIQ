<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('UPDATE sites SET license_key = LOWER(license_key)');
    }

    public function down(): void
    {
        // Lowercasing is irreversible — original casing is not stored
    }
};
