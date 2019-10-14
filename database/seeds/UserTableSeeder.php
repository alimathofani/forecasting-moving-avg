<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner_role = Role::where('slug','owner')->first();
        $admin_role = Role::where('slug', 'admin')->first();
        $sales_role = Role::where('slug', 'sales')->first();

        $transaction_permission = Permission::where('model','transactions')->pluck('id');
        $item_permission = Permission::where('model','items')->pluck('id');
        $user_permission = Permission::where('model','users')->pluck('id');
        
	    $owner = new User();
	    $owner->name = 'I Am The Owner';
	    $owner->email = 'owner@gmail.com';
	    $owner->password = bcrypt('secret');
	    $owner->save();
	    $owner->roles()->attach($owner_role);
        $owner->permissions()->attach($transaction_permission);
        $owner->permissions()->attach($item_permission);
        $owner->permissions()->attach($user_permission);
        
	    $admin = new User();
	    $admin->name = 'I Am Admin';
	    $admin->email = 'admin@gmail.com';
	    $admin->password = bcrypt('secret');
	    $admin->save();
	    $admin->roles()->attach($admin_role);
	    $admin->permissions()->attach($transaction_permission);
        $admin->permissions()->attach($item_permission);
        
	    $sales = new User();
	    $sales->name = 'I Am Sales';
	    $sales->email = 'sales@gmail.com';
	    $sales->password = bcrypt('secret');
	    $sales->save();
	    $sales->roles()->attach($sales_role);
	    $sales->permissions()->attach($transaction_permission);
        
    }
}
