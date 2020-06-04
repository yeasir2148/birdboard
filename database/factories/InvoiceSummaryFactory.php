<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceSummary;
use App\Store;
use Faker\Generator as Faker;

$factory->define(InvoiceSummary::class, function (Faker $faker) {
   $store = Store::find(1);
   $storeId = $store ? $store->id : factory(Store::class)->create()->id;

   return [
      'invoice_no' => $faker->randomNumber(6),
      // 'value' => 0,
      'invoice_date' => $faker->date('Y-m-d'),
      'store_id' => $storeId,
      'user_id' => 1
   ];
});
