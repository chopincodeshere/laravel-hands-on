<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::factory(10)->createQuietly();
        foreach ($posts as $post) {
            $files = File::factory(3)->for($post->user, 'owner')->make();
            $post->files()->saveMany($files);
            $comments = PostComment::factory(5)->for($post)->create();
            $user_ids = User::inRandomOrder()->limit(rand(0, 5))->get()->pluck('id');
            $post->likers()->sync($user_ids);
            $tag_ids = Tag::inRandomOrder()->limit(rand(0, 4))->get()->pluck('id');
            $post->tags()->sync($tag_ids);
            foreach ($comments as $comment) {
                $comment->likers()->sync($user_ids);
            }
        }
    }
}
