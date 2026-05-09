<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'username',
        'status',
        'verified',
        'resettable',
        'roles_mask',
        'registered',
        'last_login',
        'force_logout'
    ];

    public $timestamps = false; // Delight Auth handles 'registered' as a timestamp but not via Eloquent's default created_at/updated_at
}