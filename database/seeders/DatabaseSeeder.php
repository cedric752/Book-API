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

        
        $books->each(function($book) use ($genres){
            $random = rand(1, $genres->count());

            $shuffledGenres = $genres->shuffle();
            
            for($i = 0; $i < $random; $i++){
                $book->genres()->attach($shuffledGenres[$i]);
            }
        });

        $authors->each(function($author) use ($books){
            $random = rand(1, $books->count());

            $shuffledBooks = $books->shuffle();
            
            for($i = 0; $i < $random; $i++){
                $author->books()->attach($shuffledBooks[$i]);
            }
        });

    }
}
