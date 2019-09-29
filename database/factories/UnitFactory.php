<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
   $units = ['KG','GRAM','LITER'];
   $ind = rand(0, count($units) - 1);
   return [
      'unit_name' => $units[$ind],
      'unit_code' => strtolower($units[$ind])
   ];
});
