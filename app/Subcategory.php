<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Subcategory extends Model
{
   protected $guarded = [];

   public function category() {
      return $this->belongsTo(category::class);
   }

   public function items() {
      return $this->hasMany(Item::class, 'subcat_id');
   }

   public function getCrudPath() {
      return "/subcategory/{$this->id}";
   }

   

}
