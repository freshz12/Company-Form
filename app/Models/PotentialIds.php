<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialIds extends Model
{
    use HasFactory;

    protected $table = 'potential_service_offered_by_ids';

    protected $guarded = ['id'];
}
