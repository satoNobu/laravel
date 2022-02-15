<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'blog_id' => Blog::factory(),
            'name' => $this->faker->name,
            'body' => $this->faker->realText(20),
        ];
    }
}
