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
        Schema::table('employee', function (Blueprint $table) {
            $table->unsignedBigInteger('status_work_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
    
            $table->foreign('status_work_id')->references('id')->on('status_work')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
