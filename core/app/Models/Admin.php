<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;
    use Notifiable;

    protected $guarded = [];
    
    public function role()
	{
		return $this->belongsTo(PermissionRole::class, 'role_id', 'id');
	}

}
