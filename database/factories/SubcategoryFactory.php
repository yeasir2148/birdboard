<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subcategory;

use Faker\Generator as Faker;
use App\Category;

$factory->define(Subcategory::class, function (Faker $faker) {
   $name = $faker->word;
   $existingCategories = Category::all('id');
   $maxCat = (count($existingCategories)) ? $existingCategories->max()->id : factory(Category::class,5)->create()->pluck('id')->max();
   // $maxCat = Category::all('id')->max()->id;
   // dd($allCat);
   return [
      'subcat_name' => $name,
      'subcat_code' => strtolower($name),
      'category_id' => rand(1, $maxCat)
   ];
});
