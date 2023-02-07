<?php

namespace Database\Seeders;

use App\Models\Article;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        
        for($i=0; $i<10; $i++){
            Article::create([
                'stock_name' => $faker->word(),
                'text' => $faker->word(),
                'user_id' => 1,
                'created_at' => $faker->datetime('now'),
                'updated_at' => $faker->datetime('now'),
            ]);
        }
    }
}
