<?php

namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait 
{
    public function getRoleNames()
    {
        return $this->roles->pluck('name');
    }

    public function givePermissionsTo($permissions) 
    {
        $permissions = $this->getAllPermissions($permissions);
		if($permissions === null) {
			return $this;
        }
        // dd($permissions);
		$this->permissions()->sync($permissions);
		return $this;
    }
    
    public function withdrawPermissionsTo( ... $permissions ) 
    {
		$permissions = $this->getAllPermissions($permissions);
		$this->permissions()->detach($permissions);
		return $this;
    }
    
    public function refreshPermissions( ... $permissions ) 
    {
		$this->permissions()->detach();
		return $this->givePermissionsTo($permissions);
    }
    
    public function hasPermissionTo($permission) 
    {
		return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }
    
    public function hasPermissionThroughRole($permission) 
    {
		foreach ($permission->roles as $role){
			if($this->roles->contains($role)) {
				return true;
			}
		}
		return false;
    }

    public function hasPermissionInRole($permissions) 
    {
        foreach ($permissions as $permission) {
            foreach ($this->roles as $role) {
                if($role->permissions->contains('slug',$permission)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function hasRole(... $roles) 
    {
        foreach ($roles as $role) {
			if ($this->roles->contains('slug', $role)) {
				return true;
            }
		}
		return false;
    }
    
    public function roles() 
    {
		return $this->belongsToMany(Role::class,'users_roles');
    }
    
    public function permissions() 
    {
		return $this->belongsToMany(Permission::class,'users_permissions');
    }
    
    protected function hasPermission($permission) 
    {
		return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }
    
    protected function getAllPermissions(array $permissions) 
    {
		return Permission::whereIn('slug',$permissions)->get();
	}
}