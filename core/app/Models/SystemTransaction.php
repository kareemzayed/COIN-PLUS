<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemTransaction extends Model
{
	use HasFactory;

	protected $guarded = [];

	public function transactional()
	{
		return $this->morphTo();
	}

	public function report()
	{
		return $this->hasOne(TransactionReport::class, 'transaction_id', 'id');
	}
}
