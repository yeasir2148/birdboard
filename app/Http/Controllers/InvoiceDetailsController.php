<?php

namespace App\Http\Controllers;

use App\InvoiceDetail;
use App\InvoiceSummary;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $invoiceDetails = InvoiceDetail::all();
      $data = [
         'invoice_details' => $invoiceDetails,
      ];

      if(request()->ajax() || App()->runningUnitTests()) {
         return response()->json($data);
      }
      // dd(App()->runningUnitTests());
      return view('invoices.invoice-detail', compact('data'));
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
         'invoice_id' => 'required',
         'item_id' => 'required | exists:items,id',
         'quantity' => 'required | regex:/^[\d\.]+$/',
         'unit_id' => 'required | exists:units,id',
         'price' => 'required | regex:/^[\d\.]+$/',
      ]);

      $newInvoiceDetail = InvoiceDetail::create($validatedAttributes);

      if($newInvoiceDetail->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $this->updateInvoiceSummaryValue($newInvoiceDetail);
         $result = [
            'model' => $newInvoiceDetail,
            'withDetails' => $newInvoiceDetail->withRelatedInformation()
         ];
         $response['success'] = true;
         $response['data'] = $result;
      }

      if(isRequestAjaxOrTesting()) {
         return response()->json($response);
      }

      return back();
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\InvoiceDetail  $invoiceDetail
    * @return \Illuminate\Http\Response
    */
   public function show(InvoiceDetail $invoiceDetail)
   {
      
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\InvoiceDetail  $invoiceDetail
    * @return \Illuminate\Http\Response
    */
   public function edit(InvoiceDetail $invoiceDetail)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\InvoiceDetail  $invoiceDetail
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, InvoiceDetail $invoiceDetail)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\InvoiceDetail  $invoiceDetail
    * @return \Illuminate\Http\Response
    */
   public function destroy(InvoiceDetail $invoiceDetail)
   {
      $price = $invoiceDetail->price;
      $invoiceSummary = $invoiceDetail->invoice;

      $success = $invoiceDetail->delete();
      if($success) {
         $invoiceSummary->value = $invoiceSummary->value - $price;
         $invoiceSummary->save();
      }

      if(isRequestAjaxOrTesting()) {
         return response()->json([
            'success' => $success
         ]);
      }
   }

   protected function updateInvoiceSummaryValue(InvoiceDetail $invoiceDetail) {
      $invoiceSummary = $invoiceDetail->invoice;

      $invoiceSummary->value += $invoiceDetail->price;
      $invoiceSummary->save();
   }
}
