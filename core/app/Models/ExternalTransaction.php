<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transactional()
	{
		return $this->morphOne(SystemTransaction::class, 'transactional');
	}
}
