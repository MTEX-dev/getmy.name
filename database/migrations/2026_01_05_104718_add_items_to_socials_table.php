<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('socials', function (Blueprint $table) {
            $table->string('stackoverflow')->nullable();
            $table->string('bluesky')->nullable();
            $table->string('dev_to')->nullable();
            $table->string('hashnode')->nullable();
            $table->string('npm')->nullable();
            $table->string('product_hunt')->nullable();
            $table->string('polywork')->nullable();
            $table->string('gitlab')->nullable();
            $table->string('dribbble')->nullable();
            $table->string('figma')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('socials', function (Blueprint $table) {
            $table->dropColumn([
                'stackoverflow',
                'bluesky',
                'dev_to',
                'hashnode',
                'npm',
                'product_hunt',
                'polywork',
                'gitlab',
                'dribbble',
                'figma',
            ]);
        });
    }
};