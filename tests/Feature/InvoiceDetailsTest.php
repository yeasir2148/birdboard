<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\InvoiceDetail;
use App\InvoiceSummary;
use App\Unit;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceDetailsTest extends TestCase
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
    public function authenticated_user_can_create_invoice_detail()
    {
       // There must be some items in the table
       $invoiceDetail = factory(InvoiceDetail::class)->raw();

       $user = factory(User::class)->make();
       $this->actingAs($user);
       $response = $this->post('/invoice-detail', $invoiceDetail);
    //    dd($response);
       $this->assertDatabaseHas('invoice_details', $invoiceDetail);
    }

   /** @test */
   public function an_invoice_detail_belongs_to_an_invoice()
   {
      $invoiceDetail = factory(InvoiceDetail::class)->create();
      // $invoiceId = $invoiceDetail->invoice_id;
      $this->assertInstanceOf(InvoiceSummary::class, $invoiceDetail->invoice);
   }
   
   /** @test */
   public function adding_invoice_detail_updates_invoice_summary_value()
   {
      // $this->withExceptionHandling();
      $invoice = factory(InvoiceSummary::class)->create();
      $invoiceDetail1 = factory(InvoiceDetail::class)->raw(['invoice_id' => $invoice->id, 'price' => 50]);
      $invoiceDetail2 = factory(InvoiceDetail::class)->raw(['invoice_id' => $invoice->id, 'price' => 100]);
      $user = factory(User::class)->make();
      $this->actingAs($user);
      $this->post('/invoice-detail', $invoiceDetail1);
      $response = $this->post('/invoice-detail', $invoiceDetail2);
      
      $this->assertEquals(150, $response->decodeResponseJson()['data']['model']['invoice']['value']);
   }
   
}
