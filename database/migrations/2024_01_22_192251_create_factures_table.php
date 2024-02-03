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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('number_facture');
            $table->string('company_assurance')->nullable();
            $table->date('date_sinistre')->nullable();
            $table->date('date_mission')->nullable();
            $table->string('ref_sinistre')->nullable();
            $table->string('assure')->nullable();
            $table->string('tiers')->nullable();
            $table->string('vehicule')->nullable();
            $table->string('immatriculation')->nullable();
            $table->string('place')->nullable();
            $table->string('type_prestation');
            $table->double('amount');
            $table->date('date_facture');
            $table->string('facture_physical')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
