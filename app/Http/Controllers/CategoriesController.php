<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
      $categories = Category::all();
      if(request()->ajax() || App()->runningUnitTests()) {
         return response()->json($categories);
      }
      // dd(App()->runningUnitTests());
      return view('categories.index', compact('categories'));
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
         'name' => 'required',
         // 'category_code' => 'required'
      ]);

      $categoryCode = explode(" ", $validatedAttr['name']);
      $categoryCode = array_map(function($str){
         return strtolower($str);
      }, $categoryCode);

      $categoryCode = implode("_", $categoryCode);

      $newCategory = Category::firstOrCreate(
         ['category_code' => $categoryCode],
         ['name' => $validatedAttr['name']]
      );

      if ($newCategory->wasRecentlyCreated !== true) {
         $response['success'] = false;
         $response['message'] = 'Record already exists';
      } else {
         $response['success'] = true;
         $response['data'] = $newCategory;
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
   public function destroy(Category $category)
   {
      $success = $category->delete();
      return response()->json(['success' => $success]);
   }
}
