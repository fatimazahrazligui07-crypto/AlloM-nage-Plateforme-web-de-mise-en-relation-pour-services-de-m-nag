<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('prestations', function (Blueprint $table) {
            $table->decimal('montant_paye', 8, 2)->nullable()->after('id_paiement');
        });
    }

    public function down(): void
    {
        Schema::table('prestations', function (Blueprint $table) {
            $table->dropColumn('montant_paye');
        });
    }
};
