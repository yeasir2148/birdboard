<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subcategory;

class Item extends Model
{
   protected $guarded = [];

   public function subcategory() {
      return $this->belongsTo(Subcategory::class,'subcat_id');
   }
}
