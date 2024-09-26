<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        $categories = DB::table('categories')->pluck('id');


        foreach (range(1, 50) as $index) {
            DB::table('products')->insert([
                'category_id' => $faker->randomElement($categories),
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 1, 100),
                'image' => $faker->imageUrl(640, 480, 'products'), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
