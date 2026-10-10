<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'motdepasse',
        'num_telephone',
        'dateInscription',
        'role', 
        'status',
    ];

    protected $hidden = [
        'motdepasse',
        'remember_token',
    ];

    protected $casts = [
        'dateInscription' => 'date',
       // 'role' => 'integer', Cast en integer
    ];

    // Constantes pour les rôles
      const ROLE_ADMIN = 'admin';
      const ROLE_CLIENT = 'client';
      const ROLE_PRESTATAIRE = 'prestataire';

    // Relation avec Client
    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    // Méthodes helper pour les rôles
    
     public function isAdmin()
  {
      return $this->role === self::ROLE_ADMIN;
  }
  public function isClient()
  {
      return $this->role === self::ROLE_CLIENT;
  }
  public function isPrestataire()
  {
      return $this->role === self::ROLE_PRESTATAIRE;
  }

    public function getRoleNameAttribute()
    {
        switch ($this->role) {
            case self::ROLE_ADMIN:
                return 'Admin';
            case self::ROLE_CLIENT:
                return 'Client';
            case self::ROLE_PRESTATAIRE:
                return 'Prestataire';
            default:
                return 'Inconnu';
        }
    }

    // Override pour utiliser 'motdepasse' au lieu de 'password'
    public function getAuthPassword()
    {
        return $this->motdepasse;
    }
}
