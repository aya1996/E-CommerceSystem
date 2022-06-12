<?php

namespace Tests\Feature;

use App\Models\Color as ModelsColor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
  
     
    public function test_it_can_create_a_color()
    {
        $response = $this->post('/api/color', [
            'name' => [
                'en' => 'Color Name',
                'ar' => 'اسم اللون'
                
            ],
            'code' => '#000000',
           
        ]);
       // dd($response->json());
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Color::all());

    }

    public function test_it_can_update_a_color()
    {
        $color = ModelsColor::factory()->create();
        $response = $this->put('/api/colors/' . $color->id, [
            'name' => [
                'en' => 'Color Name',
                'ar' => 'اسم اللون'
            ],
            'code' => '#000000',
           
        ]);
        $response->assertStatus(200);
         //   dd($response->json());
    }

    public function test_it_can_delete_a_color()
    {
        $color = ModelsColor::factory()->create();
        $response = $this->delete('/api/colors/' . $color->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Color::all());
    }

    public function test_it_can_get_a_color()
    {
        $color = ModelsColor::factory()->create();
        $response = $this->get('/api/colors/' . $color->id);
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Color::all());
    }

    public function test_it_can_get_all_colors()
    {
        ModelsColor::factory()->create();
        $response = $this->get('/api/colors');
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Color::all());
    }


}
