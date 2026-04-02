<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            if (!Schema::hasColumn('sites', 'domain')) {
                $table->string('domain')->default('')->after('activated_url');
            }
            if (!Schema::hasColumn('sites', 'gam_network_id')) {
                $table->string('gam_network_id')->default('')->after('gam_email');
            }
        });

        // Back-fill domain for any rows that were already activated
        DB::table('sites')
            ->where('activated', true)
            ->whereNotNull('activated_url')
            ->where('activated_url', '!=', '')
            ->orderBy('id')
            ->each(function ($site) {
                $host = parse_url($site->activated_url, PHP_URL_HOST) ?? '';
                $host = preg_replace('/^www\./i', '', strtolower($host));
                if ($host) {
                    DB::table('sites')->where('id', $site->id)->update(['domain' => $host]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn(['domain', 'gam_network_id']);
        });
    }
};
