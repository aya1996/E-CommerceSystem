<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_it_can_create_a_order()
    {
        $response = $this->post('/api/order', [
            'products' => [1, 2, 3],
            'user_id' => 1,
            'shipping_date' => '2020-01-01',
            'delivery_date' => '2020-01-05',
            'status' => [
                'en' => 'pending',
                'ar' => 'قيد الانتظار'
            ],

        ]);
        // dd($response->json());
        $response->assertStatus(200);
    }

    public function test_it_can_update_a_order()
    {
        $order = Order::factory()->create();
        // dd($order);
        $response = $this->put('/api/orders/' . $order->id, [
            'products' => [1, 2, 4],
            'user_id' => 1,
            'shipping_date' => '2020-01-01',
            'delivery_date' => '2020-01-05',
            'status' => [
                'en' => 'pending',
                'ar' => 'قيد الانتظار'
            ],
            'quantity' => 1,

        ]);
       // dd($response->json());
        $response->assertStatus(200);
    }

    public function test_it_can_delete_a_order()
    {
        $order = Order::factory()->create();
        $response = $this->delete('/api/orders/' . $order->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }

    public function test_it_can_get_a_order()
    {
        $order = Order::factory()->create();
        $response = $this->get('/api/orders/' . $order->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }

    public function test_it_can_get_all_orders()
    {
      //  Order::factory()->create();
        $response = $this->get('/api/orders');
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }
}
