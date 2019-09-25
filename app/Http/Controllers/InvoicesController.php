<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Item;
use App\Unit;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $invoices = Invoice::all();
      $items = Item::all();
      $units = Unit::all();

      $response = [
         'invoices' => $invoices,
         'items' => $items,
         'units' => $units
      ];

      if(request()->ajax() || App()->runningUnitTests()) {
         return response()->json($response);
      }
      // dd(App()->runningUnitTests());
      return view('invoices.index', compact('response'));
   
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      // var_dump(Item::all('id')->pluck('id'));
      // var_dump($request->all());
      $validatedAttributes = $request->validate([
         'invoice_no' => 'required',
         'item_id' => 'required | exists:items,id',
         'quantity' => 'required | numeric',
         'unit_id' => 'required | exists:units,id',
         'price' => 'required | numeric',
         'invoice_date' => 'required | date'
      ]);

      $newInvoice = Invoice::create($validatedAttributes);

      if($newInvoice->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newInvoice;
      }

      if(isRequestAjaxOrTesting()) {
         return response()->json($response);
      }

      return back();
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
   public function show(Invoice $invoice)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
   public function edit(Invoice $invoice)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Invoice $invoice)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
   public function destroy(Invoice $invoice)
   {
      //
   }
}
