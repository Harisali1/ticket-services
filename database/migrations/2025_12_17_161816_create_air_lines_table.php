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
        Schema::create('air_lines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('awb_prefix')->nullable();
            $table->string('country')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_lines');
    }
};
