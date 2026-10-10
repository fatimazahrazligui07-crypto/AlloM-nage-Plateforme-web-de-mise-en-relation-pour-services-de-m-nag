<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestataire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'quartier_id',
        'admin_id',
        'nom_Entreprise',
        'Bank',
        'ICE',
        'RIB',
        'ContratDeBank',
        'logo',
        'is_verify'
    ];

    protected $casts = [
        //'is_active' => 'boolean',
        'is_verify' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }

    /**
     * Relation avec le quartier
     */
    public function quartier()
    {
        return $this->belongsTo(Quartier::class);
    }

    /**
     * Relation avec l'admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function offre()
    {
        return $this->hasMany(Offre::class);
    }

    /**
     * Récupérer la ville du prestataire
     */
    public function getVilleAttribute()
    {
        return $this->quartier->ville->nom_ville ?? null;
    }

    /**
     * Récupérer le nom du quartier du prestataire
     */
    public function getQuartierNomAttribute()
    {
        return $this->quartier->nom_quartier ?? null;
    }
}
