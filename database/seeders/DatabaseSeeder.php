<?php

namespace Database\Seeders;

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
        //Vul database met dummy data
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);


        \App\Models\Author::factory(10)->create(); 
        $genres = \App\Models\Genre::factory(4)->create();
        $books = \App\Models\Book::factory(100)->create();

        
        $books->each(function($book) use ($genres){
            $random = rand(1, $genres->count());

            $shuffledGenres = $genres->shuffle();
            
            for($i = 0; $i < $random; $i++){
                $book->genres()->attach($shuffledGenres[$i]);
            }
        });

    }
}
