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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->integer('nbr_perstataires');
            $table->string('sexe');
            $table->integer('age');
            $table->string('ville');
            $table->string('quartier');
            $table->boolean('produit');
            $table->float('duree');
            $table->date('date');
            $table->string('etat');
            $table->boolean('change_deco');
            $table->timestamps();

        // Clés étrangères
        $table->foreignId('id_client')->constrained('clients')->onDelete('cascade');
        $table->foreignId('id_service')->constrained('services')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};