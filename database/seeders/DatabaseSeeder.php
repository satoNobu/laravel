<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Blog::factory(15)->create();
        User::factory(15)->create()->each(function($user){
            Blog::factory(random_int(1,3))->create(['user_id' => $user])->each(function($blog){
                Comment::factory(random_int(1,4))->create(['blog_id'=>$blog]);
            });
        });
    }
}
