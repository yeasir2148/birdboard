<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
   $name = $faker->word;
   return [
      'store_name' => $name,
      'store_code' => strtolower($name),
      'suburb' => $faker->word
   ];
});
