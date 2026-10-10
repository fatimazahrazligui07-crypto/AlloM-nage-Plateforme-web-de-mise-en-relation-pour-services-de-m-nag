<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = ['montant', 'datepaiement', 'etat', 'id_offre'];

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    public function prestation()
    {
        return $this->hasOne(Prestation::class);
    }
}
