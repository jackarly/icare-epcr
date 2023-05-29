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
        Schema::create('patient_observations', function (Blueprint $table) {
            $table->id();
            $table->longText('observations')->nullable();
            $table->string('age_group')->nullable();
            $table->boolean('wound')->nullable();
            $table->boolean('burn')->nullable();
            $table->double('burn_calculation', 4, 1)->nullable();
            $table->boolean('dislocation')->nullable();
            $table->boolean('fracture')->nullable();
            $table->boolean('numbness')->nullable();
            $table->boolean('rash')->nullable();
            $table->boolean('swelling')->nullable();
            $table->string('burn_classification')->nullable();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_observations');
    }
};
