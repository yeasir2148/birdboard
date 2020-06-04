<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\InvoiceSummary;
use App\InvoiceDetail;
use App\Store;
use App\User;

class InvoiceSummaryTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
   {
      parent::setUp();
      // $this->withoutExceptionHandling();
   }

	/** @test */
	public function it_has_a_user_id_attribute()
	{
      $user = \factory('App\User')->create();
      // dd($user->id);
		$invoice = \factory(InvoiceSummary::class)->create([
			'user_id' => 1
		]);

		$this->assertEquals($invoice->user_id, $user->id);
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
