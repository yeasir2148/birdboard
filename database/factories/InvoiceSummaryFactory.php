<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceSummary;
use App\Store;
use Faker\Generator as Faker;

$factory->define(InvoiceSummary::class, function (Faker $faker) {

   $storeIds = Store::all('id')->pluck('id');
   $storeCount = count($storeIds);
   $index  = rand(1, $storeCount - 1);

   $storeId = $storeIds[$index];
  
   return [
      'invoice_no' => $faker->randomNumber(6),
      'value' => 0,
      'invoice_date' => $faker->dateTimeThisYear('now','Australia/Melbourne'),
      'store_id' => $storeId,
   ];
});
