<?php

namespace Cerwyn\Laraser\database\factories;

use Cerwyn\Laraser\Book;
use Cerwyn\Laraser\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'user_id' => User::factory(1)->create()[0]->id
        ];
    }
}
