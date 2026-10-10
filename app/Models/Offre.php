<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offre extends Model
{
    use SoftDeletes;

    protected $table = 'offres';

    protected $fillable = [
        'prixpropose',
        'message',
        'id_demande',
        'id_prestataire',
        'status',  // Ajoutez la colonne 'status' ici
    ];
    

    // 👇 Relation vers Demande
    public function demande()
    {
        return $this->belongsTo(Demande::class, 'id_demande');
    }

    // 👇 Relation vers Prestataire
    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class, 'id_prestataire');
    }
}