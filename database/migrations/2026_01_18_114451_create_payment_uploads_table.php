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
        Schema::create('payment_uploads', function (Blueprint $table) {
            $table->id();
            $table->json('booking_ids')->nullable();
            $table->string('slip_no')->nullable();
            $table->string('amount')->nullable();
            $table->string('image')->nullable();
            $table->integer('created_by')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->integer('approved_by')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->datetime('approved_at')->nullable();
            $table->boolean('is_cancel')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_uploads');
    }
};
