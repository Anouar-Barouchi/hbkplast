<?php

namespace FleetCart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens;


    protected $hidden = [
        'password',
        'remember_token',
        'media',
    ];

    protected $guarded = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'lat'               => 'decimal:7',
        'lng'               => 'decimal:7',
    ];
}
