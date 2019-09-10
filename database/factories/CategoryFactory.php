<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define('App\Category', function (Faker $faker) {
    return [
        'name' => $faker->word,
        'category_code' => $faker->word
    ];
});
