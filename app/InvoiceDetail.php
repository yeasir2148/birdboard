<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InvoiceSummary;

class InvoiceDetail extends Model
{
    protected $guarded =  [];

    public function invoice() {
        return $this->belongsTo(InvoiceSummary::class, 'invoice_id');
    }

    public function withRelatedInformation() {
      return $this
         ->query()
         ->select('inD.*', 'i.id AS item_id', 'i.item_name', 'u.id AS unit_id', 'u.unit_name')
         ->from('invoice_details AS inD')
         ->join('items AS i','i.id','=','inD.item_id')
         ->join('units AS u', 'u.id', '=', 'inD.unit_id')
         ->where('inD.id','=', $this->id)
         ->first();
    }
}
