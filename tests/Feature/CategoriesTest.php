<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Subcategory;
use App\Category;
use App\User;

class CategoriesTest extends TestCase
{
   use RefreshDatabase;

   protected function setUp(): void {
      parent::setUp();
      $this->withoutExceptionHandling();
   }
   /** @test */
   public function a_user_can_create_a_category()
   {
      $user = factory(User::class)->make();
      $this->actingAs($user);
      $category = factory('App\Category')->raw();

      $this->post('/categories', $category);
      $this->assertDatabaseHas('categories', $category);
   }

   /** @test */
   public function unauthenticated_user_cannot_create_a_category()
   {
      $this->withExceptionHandling();
      $user = factory(User::class)->make();

      $category = factory('App\Category')->raw();

      $response = $this->json('post','/categories',$category);
      $response->assertStatus(401);
   }
   

   /** @test */
   public function create_category_request_needs_name()
   {
      $this->withExceptionHandling();
      $category = [
         'name' => null,
      ];

      $user = factory(User::class)->make();
      $this->actingAs($user);

      $this->post('/categories', $category)->assertSessionHasErrors('name');
      // $this->post('/categories', $category)->assertSessionHasErrors('category_code');
      $this->post('/categories', $category)->assertStatus(302);
   }

   /** @test */
   public function fetching_categories_from_db_gets_all_categories() {
      $category = factory('App\Category',3)->create();
      $data = $this->get('/categories')->decodeResponseJson();
      $this->assertEquals(count($category), count($data));
      // dd($response);
   }
   
   /** @test */
   public function a_user_can_remove_a_category()
   {
      $user = factory(User::class)->make();
      $this->actingAs($user);

      $category = factory('App\Category')->create();
      $this->delete('categories/'.$category->id);
      $this->assertDatabaseMissing('categories',['id' => $category->id]);
   }
   
   /** @test */
   public function a_category_has_subcategories()
   {
      $category = factory(Category::class)->create();
      $subCategory = factory(Subcategory::class)->create();
      
      // modify the category relation of the subcategory
      $subCategory->category()->associate($category);
      $subCategory->save();

      $this->assertInstanceOf(Subcategory::class, $category->subcategories->first());
   }
   
}
