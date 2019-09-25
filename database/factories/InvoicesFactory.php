<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use Faker\Generator as Faker;
use App\Item;
use App\Unit;

$factory->define(Invoice::class, function (Faker $faker) {
   // $items = Item::all('id');
   // $countItems = count($items);
   $item_id = factory(Item::class)->create()->id;

   $units = Unit::all('id');
   $countUnits = count($units);
   // $unit_id = $countUnits != 0 ? $units->get(rand(0, $countUnits)) : 1;
   $unit_id = 1;
   
   return [
      'invoice_no' => $faker->randomNumber(6),
      'item_id' => $item_id,
      'quantity' => rand(0, 200),
      'unit_id' => $unit_id,
      'price' => $faker->randomFloat(2, 1, 20),
      'invoice_date' => $faker->dateTimeThisYear('now','Australia/Melbourne')
   ];
});




