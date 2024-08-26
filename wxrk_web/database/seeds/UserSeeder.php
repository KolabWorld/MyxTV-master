<?php

use App\Helpers\ConstantHelper;
use App\Models\Admin;
use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('alias', 'admin')->first();

	    $admin = new Admin();
	    $admin->name = 'Admin';
        $admin->user_name = 'admin';
        $admin->email = 'admin@user.com';
	    $admin->password = 'Test123!';
	    $admin->status = ConstantHelper::ACTIVE;
	    $admin->save();
	    $admin->roles()->attach($role_admin);
    }
}