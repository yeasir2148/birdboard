<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Item;
use App\Category;
use App\Subcategory;

class ItemsTest extends TestCase
{
   use RefreshDatabase;


   protected function setUp(): void
   {
      parent::setUp();
      $this->withoutExceptionHandling();
   }

   /** @test */
   public function a_user_can_create_an_item()
   {
      $item = factory(Item::class)->raw();
      $this->post('/item', $item);
      $this->assertDatabaseHas('items',$item);
   }

   /** @test */
   public function a_user_can_remove_an_item()
   {
      $item = factory(Item::class)->create();
      $this->assertDatabaseHas('items', $item->getAttributes());
      $this->delete('/item/' . $item->id);
      $this->assertDatabaseMissing('items',$item->getAttributes());
   }

   /** @test */
   public function an_item_nedds_a_name_code_and_subcategory_id()
   {
      $this->withExceptionHandling();
      $item = factory(Item::class)->raw(
         ['item_name' => '']
      );

      $this->post('/item', $item)->assertSessionHasErrors('item_name');

      // $item = factory(Item::class)->raw(
      //    ['item_code' => '']
      // );
      // $this->post('/item', $item)->assertSessionHasErrors('item_code');

      $item = factory(Item::class)->raw(
         ['subcat_id' => '']
      );
      $this->post('/item', $item)->assertSessionHasErrors('subcat_id');
   }
   
   /** @test */
   public function it_fetches_all_items()
   {
      $items = factory(Item::class, 2)->create();
      $response = $this->get('/items');
      $data = $response->decodeResponseJson();
      // var_dump($data);
      $this->assertEquals(count($items), count($data['items']));
   }

   /** @test */
   public function it_fetches_all_subcategories_and_categories()
   {
      $items = factory(Item::class, 3)->create();  // creating items also creates subcategories in the factory
      $subcategories = Subcategory::all();

      if(!count($subcategories)) {
         factory(Subcategory::class, 2)->create();
      }

      $categories = $this->get('/categories')->decodeResponseJson();
      $data = $this->get('items')->decodeResponseJson();

      $this->assertEquals(count($subcategories), count($data['subcategories']));
      $this->assertEquals(count($categories), count($data['categories']));
   }

   /** @test */
   public function an_item_belongs_to_a_subcategory()
   {
      $this->withExceptionHandling();
      $item = seedDb(Item::class, 1, 'create')->get(0);
      // var_dump($item);
      $this->assertInstanceOf(Subcategory::class, $item->subcategory);
   }

   // protected function seedDb($model, $quantity, $method) {
   //    return factory($model, $quantity)->$method();
   // }
   
   
}
