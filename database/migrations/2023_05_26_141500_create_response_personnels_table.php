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
        Schema::create('response_personnels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_team_id');
            $table->unsignedBigInteger('personnel_id');

            $table->foreign('response_team_id')->references('id')->on('response_teams');
            $table->foreign('personnel_id')->references('id')->on('personnels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_personnels');
    }
};
