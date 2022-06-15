<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_it_can_create_a_transaction()
    {
        $response = $this->post('/api/transaction', [
            'user_id' => 1,
           
            'payment_method' => [
                'en' => 'cash',
                'ar' => ' نقدا'
            ],
            'payment_status' => [
                'en' => 'paid',
                'ar' => 'مدفوع'
            ],
            'payment_currency' => [
                'en' => 'EGP',
                'ar' => 'جنيه مصري'
            ],
            'payment_date' => '2020-01-01',

        ]);
      //
       // dd($response->json());
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Transaction::all());


    }


    public function test_it_can_update_a_transaction()
    {
        $transaction = Transaction::factory()->create([]

        );
        $response = $this->put('/api/transactions/' . $transaction->id, [
            'user_id' => 1,
            'transaction_id' => uniqid(),
            'payment_method' => [
                'en' => 'cash',
                'ar' => ' نقدا'
            ],
            'payment_status' => [
                'en' => 'paid',
                'ar' => 'مدفوع'
            ],
            'payment_amount' => 100,

            'payment_currency' => [
                'en' => 'EGP',
                'ar' => 'جنيه مصري'
            ],
           
            'payment_date' => '2020-01-01',

        ]);
      // dd($response->json());
        $response->assertStatus(200);
    }

    public function test_it_can_delete_a_transaction()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->delete('/api/transactions/' . $transaction->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Transaction::all());

    }


    public function test_it_can_get_a_transaction()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->get('/api/transactions/' . $transaction->id);
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Transaction::all());

    }

    public function test_it_can_get_all_transactions()
    {
        Transaction::factory()->create();
        $response = $this->get('/api/transactions');
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Transaction::all());

    }
}
