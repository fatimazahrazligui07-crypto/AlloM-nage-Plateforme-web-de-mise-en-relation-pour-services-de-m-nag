<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestation extends Model
{
    use HasFactory;

    protected $fillable = [
    'nom',
    'daterealisation',
    'etat',
    'id_prestataire',
    'id_client',
    'id_paiement',
    'montant_paye'  // <-- ajouté ici
];


    // Relation vers le Prestataire
    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class, 'id_prestataire');
    }

    // Relation vers le Client (à ajouter dans ta table prestations)
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    // Relation vers le Paiement
    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'id_paiement');
    }

    // Relation vers les avis (si avis liés aux prestations)
    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}
