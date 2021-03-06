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

       $user = factory(User::class)->create();
       $this->actingAs($user);
       $invoiceDetail = factory(InvoiceDetail::class)->raw();

       $response = $this->post('/invoice-detail', $invoiceDetail);
       $this->assertDatabaseHas('invoice_details', $invoiceDetail);
    }

   /** @test */
   public function an_invoice_detail_belongs_to_an_invoice()
   {
      $invoiceDetail = factory(InvoiceDetail::class)->create();
      // $invoiceId = $invoiceDetail->invoice_id;
      $this->assertInstanceOf(InvoiceSummary::class, $invoiceDetail->invoice);
   }   
}
