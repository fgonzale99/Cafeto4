<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    \DB::table('roles')->insert([
    ['name' => 'Financiero', 'guard_name' => 'web'],

    ]);
    }
}