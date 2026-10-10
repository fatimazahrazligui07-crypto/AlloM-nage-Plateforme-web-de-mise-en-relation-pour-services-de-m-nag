<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('commissions', function (Blueprint $table) {
        $table->id();
        $table->decimal('amount', 10, 2);  // Montant de la commission
        $table->string('description')->nullable();  // Description optionnelle
        $table->unsignedBigInteger('prestation_id');  // Identifiant de la prestation
        $table->foreign('prestation_id')->references('id')->on('prestations')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
