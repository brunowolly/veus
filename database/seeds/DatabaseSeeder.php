<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Bruno',
            'email' => 'brunowolly@gmail.com',
            'password' => bcrypt('senha123'),
        ]);
    }
}
