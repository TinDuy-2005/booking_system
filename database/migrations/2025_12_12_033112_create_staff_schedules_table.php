<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_staff_schedules_table.php
public function up(): void
{
    Schema::create('staff_schedules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('staff_id')->constrained()->onDelete('cascade');
        $table->tinyInteger('day_of_week')->comment('1=Thứ Hai, 7=Chủ Nhật');
        $table->time('start_time');
        $table->time('end_time');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_schedules');
    }
};
