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
        \App\Models\User::factory(10)->create();
        $tags = \App\Models\Tag::factory(10)->create();
        \App\Models\Post::factory(50)->create()->each(function($post) use ($tags) {
            $post->tags()->attach($tags->random(3));
        });
    }
}
