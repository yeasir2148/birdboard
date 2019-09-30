<?php

namespace Tests\Feature;

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
       factory(Item::class, 5)->create();
       factory(Unit::class, 3)->create();
       factory(Store::class, 3)->create();
       $invoice = factory(InvoiceSummary::class)->raw();

       $user = factory(User::class)->make();
       $this->actingAs($user);
       $response = $this->post('/invoice', $invoice);
    //    dd($response);
       $this->assertDatabaseHas('invoice_summaries', $invoice);
    }

    /** @test */
    public function an_invoice_belongs_to_a_store()
    {
        factory(Store::class, 3)->create();
        $invoice = factory(InvoiceSummary::class)->create();
        $this->assertInstanceOf(Store::class, $invoice->store);
    }
    
}