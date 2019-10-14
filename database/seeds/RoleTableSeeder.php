<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaction_permission = Permission::where('model','transactions')->pluck('id');
        $item_permission = Permission::where('model','items')->pluck('id');
        $user_permission = Permission::where('model','users')->pluck('id');
        $role_permission = Permission::where('model','roles')->pluck('id');
        $setting_permission = Permission::where('model','settings')->pluck('id');
        
        $owner_role = new Role();
	    $owner_role->slug = 'owner';
	    $owner_role->name = 'Am Owner';
	    $owner_role->save();
        $owner_role->permissions()->attach($transaction_permission);
        $owner_role->permissions()->attach($item_permission);
        $owner_role->permissions()->attach($user_permission);
        $owner_role->permissions()->attach($role_permission);
        $owner_role->permissions()->attach($setting_permission);
        
	    $admin_role = new Role();
	    $admin_role->slug = 'admin';
	    $admin_role->name = 'Am Admin';
	    $admin_role->save();
        $admin_role->permissions()->attach($transaction_permission);
        $admin_role->permissions()->attach($item_permission);
        
	    $sales_role = new Role();
	    $sales_role->slug = 'sales';
	    $sales_role->name = 'Am Sales';
	    $sales_role->save();
        $sales_role->permissions()->attach($transaction_permission);

    }
}
