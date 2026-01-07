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
        Schema::create('pnr_passengers', function (Blueprint $table) {
            $table->id();
            $table->integer('pnr_id')->nullable();
            $table->integer('passenger_type_id')->nullable();
            $table->string('price')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnr_passengers');
    }
};
