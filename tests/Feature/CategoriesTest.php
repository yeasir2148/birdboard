<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
      $category = factory('App\Category')->raw();

      $this->post('/categories', $category);
      $this->assertDatabaseHas('categories', $category);
   }

   /** @test */
   public function create_category_request_has_name_and_category_id()
   {
      $this->withExceptionHandling();
      $category = [
         'name' => null,
         'category_code' => null
      ];

      $this->post('/categories', $category)->assertSessionHasErrors('name');
      $this->post('/categories', $category)->assertSessionHasErrors('category_code');
      $this->post('/categories', $category)->assertStatus(302);
   }

   /** @test */
   public function a_user_can_view_categories() {
      $category = factory('App\Category')->create();
      $this->get('/categories')->assertSee($category->name);
   }
   
    
    
}
