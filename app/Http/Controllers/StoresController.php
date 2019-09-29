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
      $stores = Store::all();
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
         'store_code' => 'required | max:100'
      ]);
      $newStore = Store::firstOrCreate(
         ['store_code' => $validatedAttr['store_code']],
         ['store_name' => $validatedAttr['store_name']]
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
