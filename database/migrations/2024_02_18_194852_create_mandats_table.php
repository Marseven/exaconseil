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
        Schema::create('mandats', function (Blueprint $table) {
            $table->id();
            $table->string('number_mandat');
            $table->string('number_police');
            $table->string('assure');
            $table->string('tiers')->nullable();
            $table->string('number_sinistre');
            $table->date('date_sinistre');
            $table->string('place');
            $table->string('vehicule');
            $table->string('immatriculation');
            $table->text('circonstances')->nullable();
            $table->text('observations')->nullable();
            $table->string('mandat_physical')->nullable();
            $table->date('date_mandat');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandats');
    }
};
