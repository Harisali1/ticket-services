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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('paid_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
