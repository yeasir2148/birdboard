<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Subcategory;

class SubcategoriesTest extends TestCase
{
   use RefreshDatabase;

   private const TABLE = 'subcategories'; 

   protected function setUp() : void
   {
      parent::setUp();
      // $this->artisan('migrate:refresh');
      $this->withoutExceptionHandling();
   }

   public function test_a_user_can_create_a_subcategory()
   {
      $subcategory = factory(Subcategory::class)->raw();
      // var_dump($subcategory);
      $this->post('/subcategory', $subcategory);
      $this->assertDatabaseHas('subcategories', $subcategory);
   }

   /** @test */
   public function a_user_can_remove_a_subcategory()
   {
      $subcat = factory(Subcategory::class)->create();
      $this->assertDatabaseHas(self::TABLE, $subcat->getAttributes());
      $this->delete($subcat->getCrudPath());
      $this->assertDatabaseMissing(self::TABLE,$subcat->getAttributes());
   }
   
   /** @test */
   public function it_fetches_all_subcategories_form_database()
   {
      $subcategories = factory(Subcategory::class, 2)->create();
      $data = $this->get('/subcategories')->decodeResponseJson();
      $this->assertEquals(count($data['subcategories']), count($data));
      // dd($subcategories);
   }

   /** @test */
   public function it_fetches_all_categories_from_database()
   {       
      $categories = factory(Category::class, 3)->create();
      $subcategories = factory(Subcategory::class)->create();
      $data = $this->get('/subcategories')->decodeResponseJson();
      // var_dump($data);
      $this->assertEquals(count($data['categories']), count($categories));
   }

   /** @test */
   public function a_subcategory_has_a_category()
   {
      $subcat = factory(Subcategory::class)->create();
      // $this->assertObjectHasAttribute('category', $subcat);
      $this->assertInstanceOf(Category::class, $subcat->category);
   }
   
   
}
