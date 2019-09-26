<?php

namespace App\Http\Controllers;

use App\InvoiceSummary;
use App\Store;
use Illuminate\Http\Request;
use App\Item;
use App\Unit;

class InvoicesController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $invoices = InvoiceSummary::all();
      $stores = Store::all();
      $items = Item::all();
      $units = Unit::all();

      $data = [
         'invoices' => $invoices,
         'stores' => $stores,
         'items' => $items,
         'units' => $units
      ];

      if(request()->ajax() || App()->runningUnitTests()) {
         return response()->json($data);
      }
      return view('invoices.invoices-index', compact('data'));   
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
         'value' => 'required | number',
         'invoice_date' => 'required | date',
         'store_id' => 'required | exists:stores,id'
      ]);

      $newInvoiceSummary = InvoiceSummary::create($validatedAttributes);

      if($newInvoiceSummary->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newInvoiceSummary;
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
