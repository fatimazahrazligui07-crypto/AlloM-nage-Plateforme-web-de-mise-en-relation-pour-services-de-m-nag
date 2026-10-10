<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = ['note', 'commentaire', 'is_approved', 'id_client', 'id_prestataire', 'id_prestation'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }

    public function prestation()
    {
        return $this->belongsTo(Prestation::class);
    }
}
