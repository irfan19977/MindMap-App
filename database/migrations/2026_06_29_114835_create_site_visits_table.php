<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('url')->nullable();
            $table->string('user_agent')->nullable();
            $table->date('visited_date');
            $table->timestamps();

            $table->index('visited_date');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
