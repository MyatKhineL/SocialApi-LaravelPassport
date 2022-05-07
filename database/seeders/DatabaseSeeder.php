<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'KN',
            'email'=>'kn@gmail.com',
            'password'=>bcrypt('kn2511')
        ]);

        //feed
        Feed::create([
           "user_id"=>1,
           "description"=>"Hello Guys",
           "image"=>"public/images/default.png"
        ]);


        //comment
        Comment::create([
            "user_id"=>1,
            "feed_id"=>1,
            "comment"=>"good job"
        ]);

        //Like
        Like::create([
            "user_id"=>1,
            "feed_id"=>1,
        ]);
    }
}
