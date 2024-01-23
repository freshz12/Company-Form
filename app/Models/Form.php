<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'form';
    protected $primaryKey = 'id'; // Use the default primary key
    public $incrementing = true; // Enable auto-incrementing for 'id' column

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->form_id = static::generateCustomId();
        });
    }

    public static function generateCustomId()
    {
        // Generate a unique custom ID using your preferred logic
        // For example, you can use a combination of a prefix and a numeric value
        $prefix = 'FR'; // Change this prefix as needed
        $lastRecord = static::orderBy('form_id', 'desc')->first();

        if ($lastRecord) {
            $lastNumericValue = (int) substr($lastRecord->form_id, strlen($prefix));
            $nextNumericValue = $lastNumericValue + 1;
        } else {
            $nextNumericValue = 1;
        }

        $customId = $prefix . str_pad($nextNumericValue, 5, '0', STR_PAD_LEFT); // Use five-digit numeric value

        return $customId;
    }
}