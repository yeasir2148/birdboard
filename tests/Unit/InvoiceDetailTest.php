<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\InvoiceSummary;
use App\InvoiceDetail;
use App\Store;
use App\User;

class InvoiceDetailTest extends TestCase
{
	use RefreshDatabase;

   protected function setUp(): void
   {
      parent::setUp();
      // $this->withoutExceptionHandling();
   }

   /** @test */
   public function adding_invoice_detail_updates_invoice_summary_value()
   {
      // $this->withExceptionHandling();
      $user = factory(User::class)->create();
      $this->actingAs($user);

      $invoice = factory(InvoiceSummary::class)->create(['user_id' => $user->id]);
      $invoiceDetail1 = factory(InvoiceDetail::class)->raw(['invoice_id' => $invoice->id, 'price' => 50]);
      $invoiceDetail2 = factory(InvoiceDetail::class)->raw(['invoice_id' => $invoice->id, 'price' => 100]);

      $this->post('/invoice-detail', $invoiceDetail1);
      $response = $this->post('/invoice-detail', $invoiceDetail2);

      $invoice->refresh();

      $this->assertEquals(150, $invoice->value);
      $this->assertEquals(150, $response->decodeResponseJson()['data']['model']['invoice']['value']);

   }
}
