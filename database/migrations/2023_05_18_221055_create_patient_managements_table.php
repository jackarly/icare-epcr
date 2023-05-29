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
        Schema::create('patient_managements', function (Blueprint $table) {
            $table->id();
            $table->string('airway_breathing')->nullable();
            $table->string('circulation')->nullable();
            $table->string('wound_burn_care')->nullable();
            $table->string('immobilization')->nullable();
            $table->string('others1')->nullable();
            $table->longText('others2')->nullable();
            $table->string('receiving_facility')->nullable();
            $table->string('timings')->nullable();
            $table->longText('narrative')->nullable();
            $table->string('receiving_provider')->nullable();
            $table->string('provider_position')->nullable();
            $table->string('timings_arrival')->nullable();
            $table->string('timings_handover')->nullable();
            $table->string('timings_clear')->nullable();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_hospital_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_managements');
    }
};
