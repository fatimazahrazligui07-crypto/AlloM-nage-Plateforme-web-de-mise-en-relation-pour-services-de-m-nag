<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title', 'description', 'logo', 'type_id'];

    public function typeService()
    {
        return $this->belongsTo(TypeService::class,'type_id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}