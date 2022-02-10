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
        $this->call(GenreSeeder::class);


        $authors = \App\Models\Author::factory(10)->create(); 
        $genres = \App\Models\Genre::all();
        $books = \App\Models\Book::factory(100)->create();

        
        $books->each(function($book) use ($genres, $authors){
            $randomGenres = rand(1, $genres->count());
            $randomAuthors = rand(1, $authors->count());

            $shuffledGenres = $genres->shuffle();
            $shuffledAuthors = $authors->shuffle();
            
            
            for($i = 0; $i < $randomGenres; $i++){
                $book->genres()->attach($shuffledGenres[$i]);
            }
            for($i = 0; $i < $randomAuthors; $i++){
                $book->authors()->attach($shuffledAuthors[$i]);
            }
        });
    }
}
