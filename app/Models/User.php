<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'employee';

    protected $primaryKey = 'SEQ';

    // public function getAuthIdentifier()
    // {
    //     return $this->getKey();
    // }



    // public function user(){
    //     return $this->belongsTo(User::class, 'IDSAP', 'IDSAP');
    // }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }

    public $timestamps = false;

    protected $guarded = [
        'created_at',
    ];
}