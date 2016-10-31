<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Role::truncate();

        Role::create([
            'id' => 1,
            'name' => 'admin', 
            'display_name' => 'System Administrator', 
            'description' => 'Application super user. Users with this role has no restriction.'
        ]);

        Role::create([
            'id' => 2,
            'name' => 'owner', 
            'display_name' => 'Application Owner', 
            'description' => 'Application owner. Little restriction. Just to differentiate from the system admin.'
        ]);

        /**
         * Assing some roles to the default user
         * @var [type]
         */
        $user = User::find(1);

        $user->roles()->sync([1,2]);

        Model::reguard();
    }
}