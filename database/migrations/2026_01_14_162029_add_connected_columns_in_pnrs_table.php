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
        Schema::table('pnrs', function (Blueprint $table) {
            $table->integer('middle_arrival_id')->nullable()->after('arrival_id');
            $table->string('middle_arrival_time')->nullable()->after('departure_time');
            $table->string('rest_time')->nullable()->after('middle_arrival_time');
            $table->integer('return_middle_arrival_id')->nullable()->after('return_arrival_id');
            $table->string('middle_return_arrival_time')->nullable()->after('return_departure_time');
            $table->string('return_rest_time')->nullable()->after('middle_return_arrival_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pnrs', function (Blueprint $table) {
            //
        });
    }
};
