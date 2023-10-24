<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insertar los roles 'author', 'editor' y 'admin' en la tabla 'roles'
        DB::table('roles')->insert([
            ['name' => 'author'],
            ['name' => 'editor'],
            ['name' => 'admin'],
        ]);
    }
}