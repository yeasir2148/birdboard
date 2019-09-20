<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subcategory;

use Faker\Generator as Faker;
use App\Category;

$factory->define(Subcategory::class, function (Faker $faker) {
   $name = $faker->word;
   $existingCategories = Category::all('id')->pluck('id')->toArray();

   if(empty($existingCategories)) {
      $categoryId = factory(Category::class)->create()->id;
   } else {
      $index = rand(0, count($existingCategories) - 1);
      $categoryId = $existingCategories[$index];
   }
   return [
      'subcat_name' => $name,
      'subcat_code' => strtolower($name),
      'category_id' => $categoryId
   ];
});
