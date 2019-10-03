<?php

namespace Tests\Feature;

use App\InvoiceSummary;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Store;

class StoresTest extends TestCase
{
   use RefreshDatabase;

   protected function setUp(): void
   {
      parent::setUp();
      $this->withoutExceptionHandling();
   }

   /** @test */
   public function a_user_can_create_a_store()
   {
      $store = factory(Store::class)->raw();
      $this->post('/store', $store);
      $this->assertDatabaseHas('stores', $store);
   }

   /** @test */
   public function a_user_can_remove_a_store()
   {
      $store = factory(Store::class)->create();
      // dd($store);
      $this->delete('/store/' . $store->id);
      $this->assertDatabaseMissing('stores', $store->getAttributes());
   }

   /** @test */
   public function a_store_nedds_a_name_and_code()
   {
      $this->withExceptionHandling();
      $store = factory(Store::class)->raw(
         ['store_name' => '']
      );

      $this->post('/store', $store)->assertSessionHasErrors('store_name');

      // $store = factory(Store::class)->raw(
      //    ['store_code' => '']
      // );
      // $this->post('/store', $store)->assertSessionHasErrors('store_code');
   }
   
   /** @test */
   public function it_fetches_all_stores()
   {
      $stores = factory(Store::class, 3)->create();
      $response = $this->get('/stores');
      $data = $response->decodeResponseJson();
      // var_dump($data);
      $this->assertEquals(count($stores), count($data));
   }

   /** @test */
   public function a_store_can_have_invoices()
   {
      $store = factory(Store::class)->create();
      $invoices = factory(InvoiceSummary::class, 2)->create([
         'store_id' => $store->id
      ]);

      // var_dump($store->invoiceSummaries);
      $this->assertInstanceOf(InvoiceSummary::class, $store->invoiceSummaries[0]);
   }
   
}
