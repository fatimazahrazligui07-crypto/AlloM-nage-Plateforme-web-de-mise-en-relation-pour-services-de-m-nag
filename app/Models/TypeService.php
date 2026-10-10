<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeService extends Model
{
    use HasFactory;
protected $table = 'types_services';
    protected $fillable = ['nom_type'];

   
    // Relation avec Service
    public function services()
    {
        return $this->hasMany(Service::class, 'type_id');
    }
}
