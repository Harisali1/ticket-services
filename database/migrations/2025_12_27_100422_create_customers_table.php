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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->nullable();
            $table->string('dept_ticket_no')->nullable();
            $table->string('arr_ticket_no')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('name_prefix')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('passport_type')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_country')->nullable();
            $table->string('nationality')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
