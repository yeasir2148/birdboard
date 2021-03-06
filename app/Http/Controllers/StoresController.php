<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;

class StoresController extends Controller
{
   public function __construct()
   {
      // $this->middleware('auth')->except('index');
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $stores = Store::orderBy('store_name')->get();
      if(isRequestAjaxOrTesting()) {
         return response()->json($stores);
      }
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
      $response = [];
      $validatedAttr = $request->validate([
         'store_name' => 'required | max:100',
         'suburb' => 'required | max:100',
      ]);

      $optionalAttributes = [
         'phone' => $request->phone,
         'abn' => $request->abn,
         'suburb' => $request->suburb
      ];

      $validatedAttr = array_merge($validatedAttr, $optionalAttributes);

      $storeCode = explode(" ", $validatedAttr['store_name']);
      $storeCode = array_map(function($str){
         return strtolower($str);
      }, $storeCode);

      $storeCode = implode("_", $storeCode);
      $newStore = Store::firstOrCreate(
         ['store_code' => $storeCode],
         array_diff_key($validatedAttr, ['store_code' => $storeCode])
      );

      if ($newStore->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newStore;
      }

      return json_encode($response);
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
   public function show(Category $category)
   {

   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
   public function edit(Category $category)
   {
        //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Category $category)
   {
        //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
   public function destroy(Store $store)
   {
      $success = $store->delete();
      return response()->json(['success' => $success]);
   }
}
