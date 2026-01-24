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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('pnr_id')->nullable();
            $table->integer('return_pnr_id')->nullable();
            $table->string('booking_no')->nullable();
            $table->integer('paid_by')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->string('seats')->nullable();
            $table->string('price')->nullable();
            $table->string('tax')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('partial_pay_amount')->nullable();
            $table->string('meal')->nullable();
            $table->string('wheel_chair')->nullable();
            $table->string('dept_ticket_no')->nullable();
            $table->string('arr_ticket_no')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->string('admin_fee')->nullable();
            $table->boolean('payment_status')->default(1);
            $table->integer('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->boolean('is_approved')->default(0);
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
