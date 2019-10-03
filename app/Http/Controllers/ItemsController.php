<?php

namespace App\Http\Controllers;

use App\Item;
use App\Subcategory;
use App\Category;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $items = Item::with('subcategory.category')->get();
      $subcategories = Subcategory::with('category')->get();
      $categories = Category::all();

      if(isRequestAjaxOrTesting()) {
         return response()->json(
            [
               'items' => $items,
               'subcategories' => $subcategories,
               'categories' => $categories
            ]
         );
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
      // $maxSubcategoryId = Subcategory::all('id')->max()->id;

      $validatedAttributes = $request->validate([
         'item_name' => 'required | regex:/[\w\d ]+/i | max:30',
         // 'item_code' => 'required | max:30 | alpha_dash',
         'subcat_id' => "required | integer | exists:subcategories,id"
      ]);

      $itemCode = explode(" ", $validatedAttributes['item_name']);
      $itemCode = array_map(function($item){
         return strtolower($item);
      }, $itemCode);

      $itemCode = implode("_", $itemCode);
      $newItem = Item::firstOrCreate(
         ['item_code' => $itemCode],
         array_diff_key($validatedAttributes, ['item_code' => $itemCode])
      );

      if($newItem->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newItem->load('subcategory.category');
         //->load('category');
      }

      if(isRequestAjaxOrTesting()) {
         return response()->json($response);
      }

      return back();
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function show(Item $item)
   {
        //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function edit(Item $item)
   {
        //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Item $item)
   {
        //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Item  $item
    * @return \Illuminate\Http\Response
    */
   public function destroy(Item $item)
   {
      $success = $item->delete();
      if(isRequestAjaxOrTesting()) {
         return response()->json([
            'success' => $success
         ]);
      }
   }
}
