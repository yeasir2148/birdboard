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
            ->from('invoice_details AS inD')
            ->join('items AS i','i.id','=','inD.item_id')
            ->join('units AS u', 'u.id', '=', 'inD.unit_id')
            ->where('inD.id','=', $this->id)
            ->first();
    }
}
