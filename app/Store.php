<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
   protected $guarded = [];

   public function invoiceSummaries() {
      return $this->hasMany(InvoiceSummary::class);
   }
}
