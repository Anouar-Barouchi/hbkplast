<?php

namespace Modules\Order\Entities;

use FleetCart\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mission extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($mission) {
            $mission->mission_code = 'MISS/' . str_pad($mission->id, 7, '0', STR_PAD_LEFT);
            $mission->save();
        });
    }

    protected $fillable = ['order_id', 'mission_id'];
    
    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\MissionFactory::new();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}