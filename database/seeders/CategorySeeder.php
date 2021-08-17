<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Category::factory(2)->create();
        DB::table('categories')->insert([
            'name' => 'Category 1',
        ]);

        DB::table('categories')->insert([
            'name' => 'Category 2',
        ]);

        DB::table('categories')->insert([
            'name' => 'Category 3',
        ]);
    }
}
