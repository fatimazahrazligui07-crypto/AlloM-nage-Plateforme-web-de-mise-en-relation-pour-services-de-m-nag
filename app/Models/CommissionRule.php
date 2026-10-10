<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CommissionRule extends Model
{
    use  SoftDeletes;
   protected $fillable = ['min_amount', 'max_amount', 'rate'];
}