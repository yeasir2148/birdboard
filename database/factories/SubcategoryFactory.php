<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subcategory;

use Faker\Generator as Faker;
use App\Category;

$factory->define(Subcategory::class, function (Faker $faker) {
   $name = $faker->word;
   $categories = factory(Category::class,5)->create();
   $maxCat = Category::all('id')->max()->id;
   // dd($allCat);
   return [
      'subcat_name' => $name,
      'subcat_code' => strtolower($name),
      'category_id' => rand(1, $maxCat)
   ];
});
