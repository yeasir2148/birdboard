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
      $user = factory(User::class)->create();
      $this->actingAs($user);

      $invoice = factory(InvoiceSummary::class)->raw();

      $response = $this->post('/invoice', $invoice);
      // $this->assertInstanceOf(InvoiceSummary::class, InvoiceSummary::find(1));
      $this->assertDatabaseHas('invoice_summaries', $invoice);
   }

   /** @test */
   public function unauthenticated_user_cannot_see_invoices()
   {
      $this->withExceptionHandling();
      // given a user
      $user = factory(User::class)->create();
      // given some invoices
      $invoices = \factory(InvoiceSummary::class, 2)->create(['user_id' => $user->id]);
      // when someone who is not logged in makes a get request
      $response = $this->get('/invoices');
      // gets a 403 error
      $response->assertUnauthorized();
   }
   
   /** @test */
   public function authenticated_user_can_see_invoices_created_by_himself_only()
   {
      // given a user
      $user = factory(User::class)->create();
      $this->actingAs($user);

      // given some invoices created by that user
      $invoicesOwn = \factory(InvoiceSummary::class, 2)->create(['user_id' => $user->id]);

      // And some inovoices created by other user
      $invoicesOthers = \factory(InvoiceSummary::class, 2)->create(['user_id' => 10]);

      // when logged in user makes a get request to fetch invoices
      $response = $this->get('/invoices');
      // dd($response->json());

      // He gets only his invoices
      $this->assertCount(2, $response->json()['invoices']);
   }
}
