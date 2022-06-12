<?php

namespace Tests\Feature;

use App\Models\Tax;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaxTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function test_it_can_create_a_tax()
    {
        $response = $this->post('/api/tax', [
            'name' => [
                'en' => 'Tax Name',
                'ar' => 'اسم الضرائب'

            ],
            'rate' => 10,

        ]);
        // dd($response->json());
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Tax::all());
    }

    public function test_it_can_update_a_tax()
    {
        $tax = Tax::factory()->create();
        $response = $this->put('/api/taxes/' . $tax->id, [
            'name' => [
                'en' => 'Tax Name',
                'ar' => 'اسم الضرائب'
            ],
            'rate' => 10,

        ]);

        $response->assertStatus(200);
        // dd($response->json());

    }

    public function test_it_can_delete_a_tax()
    {
        $tax = Tax::factory()->create();
        $response = $this->delete('/api/taxes/' . $tax->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Tax::all());
    }

    public function test_it_can_get_a_tax()
    {
        $tax = Tax::factory()->create();
        $response = $this->get('/api/taxes/' . $tax->id);
        $response->assertStatus(200);
        // dd($response->json());
        // $this->assertCount(0, \App\Models\Tax::all());

    }

    public function test_it_can_get_all_taxes()
    {
        $response = $this->get('/api/taxes');
        $response->assertStatus(200);
        // dd($response->json());
    }
}
