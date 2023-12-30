<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPurchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class, 'fund_id', 'id');
    }

    public function transactional()
	{
		return $this->morphOne(SystemTransaction::class, 'transactional');
	}
}
