<?php

namespace Tests\Feature;

use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SizeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   
    
        public function test_it_can_create_a_size()
        {
            $response = $this->post('/api/size', [
                'name' => [
                    'en' => 'Size Name',
                    'ar' => 'اسم المقاس'
                    
                ],
             
               
            ]);
           //dd($response->json());
            $response->assertStatus(200);
            // $this->assertCount(1, \App\Models\Size::all());

        }

        public function test_it_can_update_a_size()
        {
            $size = Size::factory()->create();
            $response = $this->put('/api/sizes/' . $size->id, [
                'name' => [
                    'en' => 'Size Name',
                    'ar' => 'اسم المقاس'
                ],
               
               
            ]);
               // dd($response->json());
            $response->assertStatus(200);
           
        }

        public function test_it_can_delete_a_size()
        {
            $size = Size::factory()->create();
            $response = $this->delete('/api/sizes/' . $size->id);
            $response->assertStatus(200);
            // $this->assertCount(0, \App\Models\Size::all());
        }

        public function test_it_can_get_a_size()
        {
            $size = Size::factory()->create();
            $response = $this->get('/api/sizes/' . $size->id);
            $response->assertStatus(200);
            // $this->assertCount(0, \App\Models\Size::all());
        }

        public function test_it_can_get_all_sizes()
        {
            $response = $this->get('/api/sizes');
            $response->assertStatus(200);
            // $this->assertCount(0, \App\Models\Size::all());
        }
      
        
}
