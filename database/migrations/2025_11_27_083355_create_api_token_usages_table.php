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
        Schema::create('api_token_usages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('token_id')->nullable();
            $table->foreign('token_id')->references('id')->on('personal_access_tokens')->onDelete('set null');
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('url');
            $table->string('method');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_token_usages');
    }
};
