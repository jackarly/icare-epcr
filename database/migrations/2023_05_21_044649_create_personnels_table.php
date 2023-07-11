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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('personnel_first_name')->nullable();
            $table->string('personnel_mid_name')->nullable();
            $table->string('personnel_last_name')->nullable();
            $table->longText('personnel_other')->nullable();
            $table->string('contact')->nullable();
            $table->string('birthday')->nullable();
            $table->string('sex')->nullable();
            $table->string('personnel_img')->nullable();
            $table->string('personnel_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
