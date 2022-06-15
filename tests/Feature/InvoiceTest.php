<?php

namespace Tests\Feature;

use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_it_can_create_a_invoice()
    {
        $response = $this->post('/api/invoice', [
            'products' => [1, 2, 3],
            'taxes' => [1, 2],
            'user_id' => 1,

            'invoiceDate' => '2020-01-05',
            'status' => [
                'en' => 'pending',
                'ar' => 'قيد الانتظار'
            ],

        ]);
        // dd($response->json());
        $response->assertStatus(200);
    }

    public function test_it_can_update_a_invoice()
    {
        $invoice = Invoice::factory()->create();
 
        $response = $this->put('/api/invoices/' . $invoice->id, [
            'products' => [1, 2, 4],
            'taxes' => [1, 2], 
            'user_id' => 1,  
            'invoiceDate' => '2020-01-05',
            'status' => [
                'en' => 'pending',
                'ar' => 'قيد الانتظار'
            ],

        ]);
         //dd($response->json());
        $response->assertStatus(200);
    }

    public function test_it_can_delete_a_invoice()
    {
        $invoice = Invoice::factory()->create();
        $response = $this->delete('/api/invoices/' . $invoice->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }

    public function test_it_can_get_a_invoice()
    {
        $invoice = Invoice::factory()->create();
        $response = $this->get('/api/invoices/' . $invoice->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }

    public function test_it_can_get_all_invoices()
    {
        $invoice = Invoice::factory()->create();
        $response = $this->get('/api/invoices');
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }

}
