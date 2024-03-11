<?php

namespace FleetCart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Admin\UserTable;

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

    /**
     * Get table data for the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function table()
    {
        return new UserTable($this->newQuery());
    }
}
