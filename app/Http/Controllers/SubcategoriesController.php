<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Category;

class SubcategoriesController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $subCategories = Subcategory::all();
      $categories = Category::all();
      if(request()->ajax() || App()->runningUnitTests()) {
         $data = [
            'subcategories' => $subCategories,
            'categories' => $categories
         ];
         return response()->json($data);
      }
      // dd(App()->runningUnitTests());
      return view('subcategories.index', compact('data'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {

   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $maxCategoryId = Category::all('id')->max()->id;
      // var_dump('hi');
      // var_dump($maxCategoryId);
      // dd($maxCategoryId);
      // var_dump($request->all());
      $validatedAttr = $request->validate([
         'subcat_name' => 'required | alpha_dash',
         'subcat_code' => 'required | alpha_dash',
         'category_id' => "required | integer | between:1,$maxCategoryId"
      ]);

      // dd($validatedAttr);
      $newSubcategory = Subcategory::firstOrCreate(
         ['subcat_code' => $validatedAttr['subcat_code']],
         array_diff_key($validatedAttr, ['subcat_code' => $validatedAttr['subcat_code']])
      );

      if($newSubcategory->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newSubcategory;
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Subcategory  $subcategory
    * @return \Illuminate\Http\Response
    */
   public function show(Subcategory $subcategory)
   {
        //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Subcategory  $subcategory
    * @return \Illuminate\Http\Response
    */
   public function edit(Subcategory $subcategory)
   {
        //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Subcategory  $subcategory
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Subcategory $subcategory)
   {
        //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Subcategory  $subcategory
    * @return \Illuminate\Http\Response
    */
   public function destroy(Subcategory $subcategory)
   {
        //
   }
}
