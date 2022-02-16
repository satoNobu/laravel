<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;
use App\Models\Comment;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            // 'user_id' => fucntion() {
            //     User::factory()->create()->id();
            // },
            /** 
             * 非推奨: 不要なデータが作られる可能性があるため
             */
            // 'user_id' => User::factory()->create()->id,

            'status' => Blog::OPEN,
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->realText(100),
        ];
    }
    public function seeding()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => $this->faker->biasedNumberBetween(0, 1, ['\Faker\Provider\Biased', 'linearHigh']),
            ];
        });
    }

    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Blog::CLOSED,
            ];
        });
    }

    public function withCommentsData(array $comments)
    {
        return $this->afterCreating(function (Blog $blog) use($comments){
            foreach($comments as $comment) {
                Comment::factory()->create(array_merge(
                    ['blog_id' => $blog->id],
                    $comment
                ));
            }
        });
    }
}
