<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    // Nom de la table associée
    protected $table = 'commissions';

    // Les champs autorisés pour l'insertion en masse
    protected $fillable = [
        'amount', // Montant de la commission
        'description', // Description de la commission
        'prestation_id', // ID de la prestation associée
    ];

    // Définir la relation avec la table 'prestations'
    public function prestation()
    {
        return $this->belongsTo(Prestation::class, 'prestation_id');
    }
}

