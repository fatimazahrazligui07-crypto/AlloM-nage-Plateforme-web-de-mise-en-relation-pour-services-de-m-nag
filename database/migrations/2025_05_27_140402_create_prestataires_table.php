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
        Schema::create('prestataires', function (Blueprint $table) {
            $table->id();             // clé primaire personnalisée
            $table->string('nom_Entreprise');
            $table->string('Bank');
            $table->string('ICE')->unique();
            $table->string('RIB')->unique();
            $table->string('ContratDeBank');
            $table->string('logo');

            // Clés étrangères
            $table->foreignId('user_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->foreignId('quartier_id')->constrained('quartiers')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');

            // Colonnes supplémentaires demandées
            $table->boolean('is_verify')->default(false);

            $table->timestamps();          // created_at et updated_at
            $table->softDeletes();         // deleted_at (soft delete)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestataires');
    }
};