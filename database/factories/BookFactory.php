<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Genre;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $authorIds = Author::pluck('id');
        return [
            'name' => $this->faker->name(),
            'author_id' => $this->faker->randomElement($authorIds),
        ];
    }
}
