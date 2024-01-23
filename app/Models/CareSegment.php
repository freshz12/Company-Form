<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareSegment extends Model
{
    use HasFactory;

    protected $table = 'care_segment';

    protected $guarded = ['id'];
}