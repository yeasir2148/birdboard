<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceDetail;
use App\InvoiceSummary;
use App\Item;
use App\Unit;
use Faker\Generator as Faker;

$factory->define(InvoiceDetail::class, function (Faker $faker) {
   $invoiceId = factory(InvoiceSummary::class)->create();

   $itemId = factory(Item::class)->create();
   $unitId = factory(Unit::class)->create();
   
   return [
      'invoice_id' => $invoiceId,
      'item_id' => $itemId,
      'quantity' => rand(0, 200),
      'unit_id' => $unitId,
      'price' => $faker->randomFloat(2, 1, 20),
   ];
});
