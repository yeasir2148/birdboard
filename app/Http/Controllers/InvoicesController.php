<?php

namespace App\Http\Controllers;

use App\InvoiceSummary;
use App\Store;
use Illuminate\Http\Request;
use App\Item;
use App\Unit;
use DB;

class InvoicesController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $invoices = InvoiceSummary::with('store')->get();
      $stores = Store::orderBy('store_name')->get();
      $items = Item::orderBy('item_name')->get();
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
      $validatedAttributes = $request->validate([
         'invoice_no' => 'required',
         // 'value' => 'required | numeric',
         'invoice_date' => 'required | date',
         'store_id' => 'required | exists:stores,id'
      ]);

      $newInvoiceSummary = InvoiceSummary::create($validatedAttributes)->load('store');

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
   public function show(InvoiceSummary $invoiceSummary)
   {
      if(isRequestAjaxOrTesting()) {
         return response()->json($invoiceSummary);
      }
   }


   /**
   * Display the items that belong to an invoice
   *
   * @param  \App\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
   public function getDetails(InvoiceSummary $invoiceSummary)
   {
      $invoiceItems = $invoiceSummary->getAllItems();

      $response = [
         'invoice_summary' => $invoiceSummary,
         'invoice_details' => $invoiceItems
      ];
      if(isRequestAjaxOrTesting()) {
         return response()->json($response);
      }
   }
   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
   public function edit(InvoiceSummary $invoice)
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
   public function update(Request $request, InvoiceSummary $invoice)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Invoice  $invoice
    * @return \Illuminate\Http\Response
    */
   public function destroy(InvoiceSummary $invoice)
   {
      $success = $invoice->delete();
      if(isRequestAjaxOrTesting()) {
         return response()->json([
            'success' => $success
         ]);
      }
   }
}
