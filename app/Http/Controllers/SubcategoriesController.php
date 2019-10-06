<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Category;

class SubcategoriesController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth')->except('index');
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $subCategories = Subcategory::with('category')->get();
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

      $validatedAttr = $request->validate([
         'subcat_name' => 'required | regex:/[\w\d ]+/i',
         // 'subcat_code' => 'required | alpha_dash',
         'category_id' => "required | integer | between:1,$maxCategoryId"
      ]);

      $subcategoryCode = explode(" ", $validatedAttr['subcat_name']);
      $subcategoryCode = array_map(function($str){
         return strtolower($str);
      }, $subcategoryCode);

      $subcategoryCode = implode("_", $subcategoryCode);

      $newSubcategory = Subcategory::firstOrCreate(
         ['subcat_code' => $subcategoryCode],
         array_diff_key($validatedAttr, ['subcat_code' => $subcategoryCode])
      );

      if($newSubcategory->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newSubcategory->load('category');
      }

      if($this->isRequestAjaxOrTesting($request)) {
         return response()->json($response);
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
   public function destroy(Request $request, Subcategory $subcategory)
   {
      $success = $subcategory->delete();
      if($this->isRequestAjaxOrTesting($request)) {
         return response()->json([
            'success' => $success
         ]);
      }
   }

   public function isRequestAjaxOrTesting($request) {
      return $request->ajax() || app()->runningUnitTests();
   }
}
