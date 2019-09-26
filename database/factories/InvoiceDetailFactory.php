<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceDetail;
use Faker\Generator as Faker;

$factory->define(InvoiceDetail::class, function (Faker $faker) {
   $invoiceIds = InvoiceSummary::all('id')->pluck('id');
   $count = count($invoiceIds);
   $index1  = rand(1, $count - 1);

   $itemIds = Item::all('id')->pluck('id');
   $count = count($itemIds);
   $index2  = rand(1, $count - 1);

   $unitIds = Unit::all('id')->pluck('id');
   $count = count($unitIds);
   $index3  = rand(1, $count - 1);

   $invoiceId = $invoiceIds[$index1];
   $itemId = $itemIds[$index2];
   $unitId = $unitIds[$index3];
   
   return [
      'invoice_id' => $invoiceId,
      'item_id' => $item_id,
      'quantity' => rand(0, 200),
      'unit_id' => $unit_id,
      'price' => $faker->randomFloat(2, 1, 20),
   ];
});
