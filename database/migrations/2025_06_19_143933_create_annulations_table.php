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
    Schema::create('annulations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');  // Identifiant de l'utilisateur
        $table->unsignedBigInteger('prestation_id');  // Identifiant de la prestation annulée
        $table->text('reason')->nullable();  // Raison de l'annulation
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');  // Statut de l'annulation
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        $table->foreign('prestation_id')->references('id')->on('prestations')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annulations');
    }
};
