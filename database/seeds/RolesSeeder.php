<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::Create([
            "name" => "Cocienro"
        ]);

        Role::Create([
            "name" => "Comensal"
        ]);
    }
}
