<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quartier_id',
        'admin_id',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }

    public function quartier()
    {
        return $this->belongsTo(Quartier::class);
    }

    // Relation indirecte vers la ville via le quartier
    public function ville()
    {
        return $this->hasOneThrough(Ville::class, Quartier::class, 'id', 'id', 'quartier_id', 'ville_id');
    }
}