<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Subcategory;
use App\Category;
use App\Item;
use App\User;

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

   public function a_user_can_create_a_subcategory()
   {
      $subcategory = factory(Subcategory::class)->raw();
      $user = factory(User::class)->make();
      $this->actingAs($user);

      $this->post('/subcategory', $subcategory);
      $this->assertDatabaseHas('subcategories', $subcategory);
   }

   /** @test */
   public function a_user_can_remove_a_subcategory()
   {
      $subcat = factory(Subcategory::class)->create();

      $user = factory(User::class)->make();
      $this->actingAs($user);

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
   public function a_subcategory_belongs_to_a_category()
   {
      $subcat = factory(Subcategory::class)->create();
      // $this->assertObjectHasAttribute('category', $subcat);
      $this->assertInstanceOf(Category::class, $subcat->category);
   }

   /** @test */
   public function a_subcategory_has_items()
   {
      $item = seedDb(Item::class, 1, 'create')->get(0);
      $subcat = $item->subcategory;
      $this->assertInstanceOf(Subcategory::class, $subcat);
   }
   
   
   
}
