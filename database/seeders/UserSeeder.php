<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'David Garcia',
            'email' => 'dagarcia100@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => '_ADMIN',
            'email_verified_at' => now(),
        ]);

        User::factory(60)->create();
    }
}
