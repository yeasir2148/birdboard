<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Store;
use App\InvoiceDetail;
use DB;

class InvoiceSummary extends Model
{
   protected $guarded = [];
   protected $with = ['store','invoiceDetails'];

   public function store() {
      return $this->belongsTo(Store::class);
   }

   public function invoiceDetails() {
      return $this->hasMany(invoiceDetail::class, 'invoice_id');
   }

   public function getAllItems() {
      return 
      DB::table('invoice_details AS inD')
      ->join('items AS i','i.id', '=', 'inD.item_id')
      ->join('units AS u', 'u.id', '=', 'inD.unit_id')
      ->select('i.item_name','u.unit_name','inD.*')
      ->where('inD.invoice_id','=', $this->id)
      ->orderBy('i.item_name','asc')
      ->get();
   }

   public function getItem($invoiceDetailId) {
      return 
      DB::table('invoice_details AS inD')
      ->join('items AS i','i.id', '=', 'inD.item_id')
      ->join('units AS u', 'u.id', '=', 'inD.unit_id')
      ->select('i.item_name','u.unit_name','inD.*')
      ->where('inD.id','=', $invoiceDetailId)
      ->get();
   }
}
