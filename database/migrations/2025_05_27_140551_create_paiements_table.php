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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->date('datepaiement'); // Date spécifique du paiement
            $table->enum('etat', ['en attente', 'payé', 'annulé'])->default('en attente');
            $table->timestamps(); // Dates automatiques de création/modification de la ligne



            // Clés étrangères
            $table->foreignId('id_offre')->constrained('offres')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};