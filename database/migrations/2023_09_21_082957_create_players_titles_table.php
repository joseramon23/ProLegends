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
        Schema::create('players_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('player_id')->constrained('players');
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('league_id')->constrained('leagues');
            $table->string('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players_titles');
    }
};
