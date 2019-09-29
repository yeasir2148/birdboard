<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceSummary;
use App\Store;
use Faker\Generator as Faker;

$factory->define(InvoiceSummary::class, function (Faker $faker) {

   $storeId = factory(Store::class)->create();

   return [
      'invoice_no' => $faker->randomNumber(6),
      'value' => rand(1,100),
      'invoice_date' => $faker->date('Y-m-d'),
      'store_id' => $storeId,
   ];
});
