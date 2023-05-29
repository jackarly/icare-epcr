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
        Schema::create('patient_assessments', function (Blueprint $table) {
            $table->id();
            $table->longText('chief_complaint')->nullable();
            $table->longText('history')->nullable();
            $table->string('primary1')->nullable();
            $table->string('airway')->nullable();
            $table->string('breathing')->nullable();
            $table->string('pulse')->nullable();
            $table->string('skin_appearance')->nullable();
            $table->integer('gcs_eye')->nullable();
            $table->integer('gcs_verbal')->nullable();
            $table->integer('gcs_motor')->nullable();
            $table->integer('gcs_total')->nullable();
            $table->longText('signs_symptoms')->nullable();
            $table->longText('allergies')->nullable();
            $table->longText('medications')->nullable();
            $table->longText('past_history')->nullable();
            $table->longText('last_intake')->nullable();
            $table->longText('event_prior')->nullable();
            $table->string('vital_time1')->nullable();
            $table->string('vital_time2')->nullable();
            $table->string('vital_time3')->nullable();
            $table->string('vital_bp1')->nullable();
            $table->string('vital_bp2')->nullable();
            $table->string('vital_bp3')->nullable();
            $table->string('vital_hr1')->nullable();
            $table->string('vital_hr2')->nullable();
            $table->string('vital_hr3')->nullable();
            $table->string('vital_rr1')->nullable();
            $table->string('vital_rr2')->nullable();
            $table->string('vital_rr3')->nullable();
            $table->string('vital_o2sat1')->nullable();
            $table->string('vital_o2sat2')->nullable();
            $table->string('vital_o2sat3')->nullable();
            $table->string('vital_glucose1')->nullable();
            $table->string('vital_glucose2')->nullable();
            $table->string('vital_glucose3')->nullable();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_assessments');
    }
};
