<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    public function run()
    {
        Tag::truncate();
        factory(Tag::class, 5)->create();
    }
}