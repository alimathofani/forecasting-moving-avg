<?php

namespace App;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermissionsTrait;

    protected $fillable = [
        'slug', 'name',
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
}
