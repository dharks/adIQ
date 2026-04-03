<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plugin_releases', function (Blueprint $table) {
            $table->id();
            $table->string('version', 20);
            $table->string('requires_wp', 10)->default('5.8');
            $table->string('requires_php', 10)->default('7.4');
            $table->string('tested_wp', 10)->default('6.7');
            $table->text('changelog')->nullable();
            $table->string('zip_path', 500)->nullable(); // relative to storage/app
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plugin_releases');
    }
};
