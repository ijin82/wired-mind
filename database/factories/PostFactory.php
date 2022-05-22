<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realTextBetween(20, 60),
            'text' => $this->faker->paragraphs(5, true),
            'visible' => $this->faker->randomElement([true, false])
        ];
    }
}
