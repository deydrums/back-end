<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'David Garcia',
            'email' => 'dagarcia100@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => '_ADMIN',
            'email_verified_at' => now(),
        ]);

        User::factory(60)->create();
    }
}
