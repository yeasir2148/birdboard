<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Subcategory;

class SubcategoriesTest extends TestCase
{

   use RefreshDatabase;

   protected function setUp() : void
   {
      parent::setUp();
      $this->withoutExceptionHandling();
   }

   public function test_a_user_can_create_a_subcategory()
   {
      $subcategory = factory('App\Subcategory')->raw();
      $this->post('/subcategory', $subcategory);
      $this->assertDatabaseHas('subcategories', $subcategory);
   }

   /** @test */
   public function it_fetches_all_subcategories_form_database()
   {
      $subcategories = factory(Subcategory::class, 2)->create();
      $data = $this->get('/subcategories')->decodeResponseJson();
      $this->assertEquals(count($subcategories), count($data));
      // dd($subcategories);
   }
   
}
