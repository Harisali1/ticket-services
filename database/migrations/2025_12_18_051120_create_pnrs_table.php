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
        Schema::create('pnrs', function (Blueprint $table) {
            $table->id();
            $table->string('pnr_no');
            $table->string('pnr_type')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('air_craft')->nullable();
            $table->string('class')->nullable();
            $table->string('baggage')->nullable();
            $table->integer('departure_id')->nullable();
            $table->integer('arrival_id')->nullable();
            $table->integer('airline_id')->nullable();
            $table->integer('return_departure_id')->nullable();
            $table->integer('return_arrival_id')->nullable();
            $table->integer('return_airline_id')->nullable();
            $table->string('duration')->nullable();
            $table->integer('seats');
            $table->string('price')->nullable();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->date('return_departure_date');
            $table->time('return_departure_time');
            $table->date('return_arrival_date');
            $table->time('return_arrival_time');
            $table->boolean('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnrs');
    }
};
