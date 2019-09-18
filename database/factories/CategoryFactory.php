<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define('App\Category', function (Faker $faker) {
   $name = $faker->word;
   return [
      'name' => $name,
      'category_code' => strtolower($name)
   ];
});
