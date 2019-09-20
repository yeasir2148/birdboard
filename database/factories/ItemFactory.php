<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use App\Subcategory;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
   $existingItem = Item::all('item_code')->pluck('item_code')->toArray();
   $name = $faker->word;
   while(in_array($name, $existingItem)) {
      $name = $faker->word;
   }
   
   $existingSubcategories = Subcategory::all('id')->pluck('id')->toArray();

   if(empty($existingSubcategories)) {
      $subcategoryId = factory(Subcategory::class)->create()->id;
   } else {
      $index = rand(0, count($existingSubcategories) - 1);
      $subcategoryId = $existingSubcategories[$index];
   }

   return [
      'item_name' => $name,
      'item_code' => strtolower($name),
      'subcat_id' => $subcategoryId
   ];

});
