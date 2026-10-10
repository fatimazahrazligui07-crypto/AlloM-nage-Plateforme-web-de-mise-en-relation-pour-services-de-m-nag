<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annulation extends Model
{
    use HasFactory;

    // Nom de la table associée
    protected $table = 'annulations';

    // Les champs autorisés pour l'insertion en masse
    protected $fillable = [
        'user_id', // ID de l'utilisateur ayant effectué l'annulation
        'prestation_id', // ID de la prestation annulée
        'reason', // Raison de l'annulation
        'status', // Statut de l'annulation (pending, approved, rejected)
    ];

    // Définir la relation avec la table 'utilisateurs'
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }

    // Définir la relation avec la table 'prestations'
    public function prestation()
    {
        return $this->belongsTo(Prestation::class, 'prestation_id');
    }
}
