<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Throwable;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //going throw all the default images from config
        foreach (config('default_videos') as $video_name) {

            //getting the URL of an Image
            $url = url('/') . '/' . $video_name;
            try {
                //getting the content of image to store in Storage
                $file  = file_get_contents($url);
            } catch (Throwable $th) {
                return null;
            }

            //storing the image with same name as in Config.
            if (!Storage::exists("{$video_name}")) {
                Storage::put("{$video_name}", $file);
            }
        }
    }
}
