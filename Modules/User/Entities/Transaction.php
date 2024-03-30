<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'order_id',
    ];
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\TransactionFactory::new();
    }
}
