<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->string('license_key', 32)->unique();
            $table->boolean('activated')->default(false);
            $table->string('activated_url')->default('');
            $table->timestamp('activated_at')->nullable();
            $table->boolean('gam_connected')->default(false);
            $table->string('gam_email')->default('');
            $table->timestamps();

            $table->index('license_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
