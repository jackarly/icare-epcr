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
        Schema::create('response_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_ambulance_id');
            $table->string('status')->default("available");

            $table->foreign('user_ambulance_id')->references('id')->on('user_ambulances');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_teams');
    }
};
