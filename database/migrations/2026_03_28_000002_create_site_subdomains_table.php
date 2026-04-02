<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_subdomains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            // Just the prefix — e.g. "staging", not "staging.bestbuy.com"
            $table->string('subdomain', 63);
            $table->timestamps();

            $table->unique(['site_id', 'subdomain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_subdomains');
    }
};
