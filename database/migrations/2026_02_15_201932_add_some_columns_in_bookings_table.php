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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pnr_ref_no')->nullable();
            $table->string('pnr_flight_no')->nullable();
            $table->string('pnr_air_craft')->nullable();
            $table->string('pnr_middle_flight_no')->nullable();
            $table->string('pnr_middle_air_craft')->nullable();
            $table->string('pnr_baggage')->nullable();
            $table->string('pnr_arrival')->nullable();
            $table->string('pnr_departure')->nullable();
            $table->string('pnr_middle_arrival')->nullable();
            $table->string('pnr_airline')->nullable();
            $table->string('pnr_departure_date_time')->nullable();
            $table->string('pnr_middle_arrival_time')->nullable();
            $table->string('pnr_middle_departure_time')->nullable();
            $table->string('pnr_arrival_date_time')->nullable();
            $table->string('pnr_duration')->nullable();
            $table->string('pnr_first_duration')->nullable();
            $table->string('pnr_break_time')->nullable();
            $table->string('pnr_second_duration')->nullable();
            
            $table->string('return_ref_no')->nullable();
            $table->string('return_flight_no')->nullable();
            $table->string('return_air_craft')->nullable();
            $table->string('return_middle_flight_no')->nullable();
            $table->string('return_middle_air_craft')->nullable();
            $table->string('return_baggage')->nullable();
            $table->string('return_arrival')->nullable();
            $table->string('return_departure')->nullable();
            $table->string('return_middle_arrival')->nullable();
            $table->string('return_airline')->nullable();
            $table->string('return_departure_date_time')->nullable();
            $table->string('return_middle_arrival_time')->nullable();
            $table->string('return_middle_departure_time')->nullable();
            $table->string('return_arrival_date_time')->nullable();
            $table->string('return_duration')->nullable();
            $table->string('return_first_duration')->nullable();
            $table->string('return_break_time')->nullable();
            $table->string('return_second_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
