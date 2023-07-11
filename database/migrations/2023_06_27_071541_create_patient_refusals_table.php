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
        Schema::create('patient_refusals', function (Blueprint $table) {
            $table->id();
            $table->longText('hospital_reasons');
            $table->string('hospital_nurse_doctor');
            $table->unsignedBigInteger('user_hospital_id');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_refusals');
    }
};
