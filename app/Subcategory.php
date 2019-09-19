<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
   protected $guarded = [];

   public function category() {
      return $this->belongsTo(category::class);
   }

   public function getCrudPath() {
      return "/subcategory/{$this->id}";
   }
}
