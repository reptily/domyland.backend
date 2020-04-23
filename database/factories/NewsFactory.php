<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'title' => $faker->title(),
        'preview' => $faker->text(200),
        'body' => $faker->text(1000),
        'image' => $faker->imageUrl(),
        'published_at' => $faker->date("Y-m-d"),
        'author_id' => 1
    ];
});
