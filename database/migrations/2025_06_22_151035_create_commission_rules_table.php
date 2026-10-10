<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
       // database/migrations/xxxx_xx_xx_xxxxxx_create_commission_rules_table.php
    public function up(): void
    {
        Schema::create('commission_rules', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_amount', 10, 2); // Montant minimum de l'intervalle
            $table->decimal('max_amount', 10, 2)->nullable(); // Montant maximum (peut être infini)
            $table->decimal('rate', 5, 2); // Taux de commission en pourcentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_rules');
    }
};
