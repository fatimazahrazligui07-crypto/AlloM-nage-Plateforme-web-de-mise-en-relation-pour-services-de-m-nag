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
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->date('daterealisation');
            $table->string('etat');
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreignId('id_prestataire')->constrained('prestataires')->onDelete('cascade');
            $table->foreignId('id_paiement')->constrained('paiements')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};