<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialRelation extends Model
{
    use HasFactory;

    protected $table = 'potential_relationship';

    protected $guarded = ['id'];
}
