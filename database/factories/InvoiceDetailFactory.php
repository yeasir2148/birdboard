<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceDetail;
use App\InvoiceSummary;
use App\Item;
use App\Unit;
use Faker\Generator as Faker;

$factory->define(InvoiceDetail::class, function (Faker $faker) {
   $invoice = factory(InvoiceSummary::class)->create(
      [
         'user_id' => auth()->user()->id ?? factory('App\User')->create()->id
      ]);

   $itemId = factory(Item::class)->create()->id;
   $unit = Unit::find(1);
   $unitId = $unit ? $unit->id : factory(Unit::class)->create();
   $price = $faker->randomFloat(2, 1, 20);

   // Updating the InvoiceSummary value as the InvoiceSummary factory defaults to 0 for 'value' column
   $invoice->value = $invoice->value + $price;
   $invoice->save();

   return [
      'invoice_id' => $invoice->id,
      'item_id' => $itemId,
      'quantity' => rand(0, 200),
      'unit_id' => $unitId,
      'price' => $price
   ];
});
