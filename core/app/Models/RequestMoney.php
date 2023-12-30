<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMoney extends Model
{
    use HasFactory;

    protected $guarded =[];


    public function sender()
    {
        return $this->belongsTo(User::class,'request_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_user_id');
    }
}
