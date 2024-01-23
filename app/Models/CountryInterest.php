<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryInterest extends Model
{
    use HasFactory;

    protected $table = 'country_of_interest_for_distribution';

    protected $guarded = ['id'];
}
