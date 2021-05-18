<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

$factory->define(Blog::class, function (Faker $faker) {
    $title = $faker->sentence();
    return [
        'title' => $title,
        // 'slug'  => Str::slug($title),
        'body' => $faker->text(),
        'image' => UploadedFile::fake()->image('photo1.jpg'),
        'user_id' => 20
    ];
});
