<?php

namespace App\Models;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'currency_id','balance'];

	public function currency()
	{
		return $this->belongsTo(Currency::class, 'currency_id', 'id');
	}
}
