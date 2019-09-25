<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Invoice;
use App\User;
use App\Item;
use App\Unit;

class InvoicesTest extends TestCase
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
      // factory(Item::class, 5)->create();
      factory(Unit::class)->create();
      $invoice = factory(Invoice::class)->raw();
      $user = factory(User::class)->make();
      $this->actingAs($user);
      $this->post('/invoice', $invoice);
      $this->assertDatabaseHas('invoices', $invoice);
   }
   
}
