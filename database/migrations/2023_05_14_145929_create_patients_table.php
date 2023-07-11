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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('ppcr_color')->nullable();
            $table->string('patient_first_name')->nullable();
            $table->string('patient_mid_name')->nullable();
            $table->string('patient_last_name')->nullable();
            $table->string('age')->nullable();
            $table->string('birthday')->nullable();
            $table->string('sex')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('address')->nullable();
            $table->string('patient_refused_at')->nullable();
            $table->string('patient_refusal_witness')->nullable();
            $table->string('hospital_refused_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->foreignId('incident_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
