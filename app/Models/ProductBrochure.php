<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrochure extends Model
{
    use HasFactory;

    protected $table = 'product_brochure';

    protected $guarded = ['id'];
}