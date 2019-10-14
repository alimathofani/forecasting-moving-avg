<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = Role::where('slug' ,'owner')->value('id');
        $admin = Role::where('slug' , 'admin')->value('id');
        $sales = Role::where('slug' , 'sales')->value('id');

        // ROLES
        $roles = [
            ['slug' => 'role-list','name' => 'Role List','model' => 'roles',],
            ['slug' => 'role-create','name' => 'Role Create','model' => 'roles',],
            ['slug' => 'role-show','name' => 'Role Show','model' => 'roles',],
            ['slug' => 'role-edit','name' => 'Role Edit','model' => 'roles',],
            ['slug' => 'role-delete','name' => 'Role Delete','model' => 'roles',]
        ];
        foreach ($roles as $role) {
            $data = Permission::create($role);
            $data->roles()->attach($owner);
        }

        // USERS
        $users = [
            ['slug' => 'user-list','name' => 'User List','model' => 'users',],
            ['slug' => 'user-create','name' => 'User Create','model' => 'users',],
            ['slug' => 'user-show','name' => 'User Show','model' => 'users',],
            ['slug' => 'user-edit','name' => 'User Edit','model' => 'users',],
            ['slug' => 'user-delete','name' => 'User Delete','model' => 'users',]
        ];
        foreach ($users as $user) {
            $data = Permission::create($user);
            $data->roles()->attach($owner);
        }

        // TRANSACTIONS
        $transactions = [
            ['slug' => 'transaction-list','name' => 'Transaction List','model' => 'transactions',],
            ['slug' => 'transaction-create','name' => 'Transaction Create','model' => 'transactions',],
            ['slug' => 'transaction-show','name' => 'Transaction Show','model' => 'transactions',],
            ['slug' => 'transaction-edit','name' => 'Transaction Edit','model' => 'transactions',],
            ['slug' => 'transaction-delete','name' => 'Transaction Delete','model' => 'transactions',]
        ];
        foreach ($transactions as $transaction) {
            $data = Permission::create($transaction);
            $data->roles()->attach([$owner,$admin,$sales]);
        }

        // TRANSACTIONS
        $forecastings = [
            ['slug' => 'forecasting-list','name' => 'Transaction List','model' => 'forecastings',],
            ['slug' => 'forecasting-create','name' => 'Transaction Create','model' => 'forecastings',],
            ['slug' => 'forecasting-show','name' => 'Transaction Show','model' => 'forecastings',],
            ['slug' => 'forecasting-edit','name' => 'Transaction Edit','model' => 'forecastings',],
            ['slug' => 'forecasting-delete','name' => 'Transaction Delete','model' => 'forecastings',]
        ];
        
        foreach ($forecastings as $forecasting) {
            $data = Permission::create($forecasting);
            $data->roles()->attach([$owner,$admin,$sales]);
        }

        // ITEMS
        $items = [
            ['slug' => 'item-list','name' => 'Item List','model' => 'items',],
            ['slug' => 'item-create','name' => 'Item Create','model' => 'items',],
            ['slug' => 'item-show','name' => 'Item Show','model' => 'items',],
            ['slug' => 'item-edit','name' => 'Item Edit','model' => 'items',],
            ['slug' => 'item-delete','name' => 'Item Delete','model' => 'items',]
        ];
        foreach ($items as $item) {
            $data = Permission::create($item);
            $data->roles()->attach([$owner,$admin]);
        }

        // SETTINGS
        $settings = [
            ['slug' => 'setting-list','name' => 'Setting List','model' => 'settings',],
            ['slug' => 'setting-create','name' => 'Setting Create','model' => 'settings',],
            ['slug' => 'setting-show','name' => 'Setting Show','model' => 'settings',],
            ['slug' => 'setting-edit','name' => 'Setting Edit','model' => 'settings',],
            ['slug' => 'setting-delete','name' => 'Setting Delete','model' => 'settings',]
        ];
        foreach ($settings as $setting) {
            $data = Permission::create($setting);
            $data->roles()->attach($owner);
        }

        
    }
}
