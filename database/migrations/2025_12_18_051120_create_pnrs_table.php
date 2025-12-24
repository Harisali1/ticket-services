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
            $table->integer('departure_id')->nullable();
            $table->integer('arrival_id')->nullable();
            $table->integer('airline_id');
            $table->integer('seats');
            $table->string('pnr_file')->nullable();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->boolean('status')->default(1);
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
