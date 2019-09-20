<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Item;

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
   public function an_item_nedds_a_name_code_and_subcategory_id()
   {
      $this->withExceptionHandling();
      $item = factory(Item::class)->raw(
         ['item_name' => '']
      );

      $this->post('/item', $item)->assertSessionHasErrors('item_name');

      $item = factory(Item::class)->raw(
         ['item_code' => '']
      );
      $this->post('/item', $item)->assertSessionHasErrors('item_code');

      $item = factory(Item::class)->raw(
         ['subcat_id' => '']
      );
      $this->post('/item', $item)->assertSessionHasErrors('subcat_id');
   }
   
   /** @test */
   public function it_fetches_all_items()
   {
      $items = factory(Item::class, 3)->create();
      $response = $this->get('/items');
      $data = $response->decodeResponseJson();
      $this->assertEquals(count($items), count($data));
   }   
}
