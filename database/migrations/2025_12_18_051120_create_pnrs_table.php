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
            $table->string('ref_no')->nullable();
            // $table->string('pnr_type')->nullable();
            $table->string('flight_no')->nullable();
            $table->string('air_craft')->nullable();
            $table->string('middle_flight_no')->nullable();
            $table->string('middle_air_craft')->nullable();
            // $table->string('return_flight_no')->nullable();
            // $table->string('return_air_craft')->nullable();
            $table->string('class')->nullable();
            $table->string('baggage')->nullable();

            $table->integer('departure_id')->nullable();
            $table->integer('arrival_id')->nullable();
            $table->integer('middle_arrival_id')->nullable();
            $table->integer('airline_id')->nullable();
            
            // $table->integer('return_departure_id')->nullable();
            // $table->integer('return_arrival_id')->nullable();
            // $table->integer('return_middle_arrival_id')->nullable();
            // $table->integer('return_airline_id')->nullable();
            
            $table->date('departure_date')->nullable();
            $table->time('departure_time')->nullable();
            $table->string('middle_arrival_time')->nullable();
            $table->string('rest_time')->nullable();
            $table->date('arrival_date')->nullable();
            $table->time('arrival_time')->nullable();
            
            // $table->date('return_departure_date')->nullable();
            // $table->time('return_departure_time')->nullable();
            // $table->string('middle_return_arrival_time')->nullable();
            // $table->string('return_rest_time')->nullable();
            // $table->date('return_arrival_date')->nullable();
            // $table->time('return_arrival_time')->nullable();

            $table->string('duration')->nullable();
            // $table->string('return_duration')->nullable();
            
            $table->string('base_price')->nullable();
            $table->string('tax')->nullable();
            $table->string('total')->nullable();

            // $table->string('return_base_price')->nullable();
            // $table->string('return_tax')->nullable();
            // $table->string('return_total')->nullable();

            $table->integer('seats')->nullable();
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
