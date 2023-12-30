<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'transfer_info' => 'array'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id')->withDefault();
    }

    public function sendercurrency()
    {
        return $this->belongsTo(Currency::class,'sender_currency')->withDefault();
    }
    
    public function receivercurrency()
    {
        return $this->belongsTo(Currency::class,'receiver_currency')->withDefault();
    }
}
