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
            Schema::table('utilisateurs', function (Blueprint $table) {
                $table->softDeletes(); // C'est cette ligne qui ajoute la colonne 'deleted_at'
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('utilisateurs', function (Blueprint $table) {
                $table->dropSoftDeletes(); // Permet d'annuler la migration
            });
        }
};
