<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_staff_table.php
public function up(): void
{
    Schema::create('staff', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Optional: Nếu nhân viên có tài khoản riêng
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
