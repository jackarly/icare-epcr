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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('nature_of_call')->nullable();
            $table->string('incident_type')->nullable();
            $table->string('incident_location')->nullable();
            $table->string('area_type')->nullable();
            $table->string('caller_first_name')->nullable();
            $table->string('caller_mid_name')->nullable();
            $table->string('caller_last_name')->nullable();
            $table->string('caller_number')->nullable();
            $table->string('no_of_persons_involved')->nullable();
            $table->longText('incident_details')->nullable();
            $table->longText('injuries_details')->nullable();
            $table->string('timing_dispatch')->nullable();
            $table->string('timing_enroute')->nullable();
            $table->string('timing_arrival')->nullable();
            $table->string('timing_depart')->nullable();
            $table->unsignedBigInteger('response_team_id')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
