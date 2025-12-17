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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('phone_number');
        
        // Liên kết với bảng services (đảm bảo bảng services của bạn tên là 'services')
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        
        // SỬA DÒNG NÀY: trỏ đúng vào bảng 'staff'
        $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('set null');
        
        $table->dateTime('booking_date');
        $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
        $table->text('note')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
