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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->integer('note');  // ex: 1 à 5
            $table->text('commentaire')->nullable();
            $table->boolean('is_approved')->default(false); // admin valide ou non
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreignId('id_client')->constrained('clients')->onDelete('cascade');
            $table->foreignId('id_prestataire')->constrained('prestataires')->onDelete('cascade');
            $table->foreignId('id_prestation')->constrained('prestations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};