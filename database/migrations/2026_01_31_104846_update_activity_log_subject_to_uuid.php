<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropIndex(['subject_type', 'subject_id']);
            
            $table->dropColumn(['subject_type', 'subject_id']);
        });
        
        Schema::table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->nullableUuidMorphs('subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->dropUuidMorphs('subject');
        });
        
        Schema::table(config('activitylog.table_name'), function (Blueprint $table) {
            $table->nullableMorphs('subject');
        });
    }
};