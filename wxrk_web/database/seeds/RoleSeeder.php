<?php

use App\Models\Role;
use App\Helpers\ConstantHelper;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'alias' => ConstantHelper::ROLE_ADMIN,
            ]
        ];

        Role::insert($roles);
    }
}
