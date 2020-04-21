<?php

namespace Tests\Feature;

use App\InvoiceDetail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Store;
use App\Unit;
use App\Item;
use App\InvoiceSummary;
use App\User;

class InvoiceSummariesTest extends TestCase
{
   use RefreshDatabase;

   protected function setUp(): void
   {
      parent::setUp();
      $this->withoutExceptionHandling();
   }

   /**
    * A basic feature test example.
    *
    * @return void
 */
   /** @test */
   public function authenticated_user_can_create_an_invoice()
   {
      // There must be some items in the table
      factory(Item::class)->create();
      factory(Unit::class)->create();
      factory(Store::class)->create();
      $invoice = factory(InvoiceSummary::class)->raw();

      $user = factory(User::class)->make();
      $this->actingAs($user);
      $response = $this->post('/invoice', $invoice);
      // $this->assertInstanceOf(InvoiceSummary::class, InvoiceSummary::find(1));
      $this->assertDatabaseHas('invoice_summaries', $invoice);
   }

   /** @test */
   public function an_invoice_belongs_to_a_store()
   {
      factory(Store::class, 3)->create();
      $invoice = factory(InvoiceSummary::class)->create();
      $this->assertInstanceOf(Store::class, $invoice->store);
   }
   
   /** @test */
   public function an_invoice_has_invoice_details()
   {
      $invoice = factory(InvoiceSummary::class)->create();
      $invoiceDetail = factory(InvoiceDetail::class)->create(['invoice_id' => $invoice->id]);

      $this->assertInstanceOf(InvoiceDetail::class, $invoice->invoiceDetails->first());
   }
   
}
