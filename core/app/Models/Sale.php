<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function fund()
    {
        return $this->belongsTo(Fund::class, 'fund_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function transactional()
	{
		return $this->morphOne(SystemTransaction::class, 'transactional');
	}
}
