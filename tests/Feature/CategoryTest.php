<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // use RefreshDatabase;

    public function test_it_can_create_a_category()
    {
        $response = $this->post('/api/category', [
            'name' => [
                'en' => 'Category Name',
                'ar' => 'اسم الفئة'
            ],
           
        ]);
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Category::all());

        // $this->assertDatabaseHas('categories', [
        //     'name' => [
        //         'en' => 'Category Name',
        //         'ar' => 'اسم الفئة'
        //     ],     
        // ]);
    }

    public function test_it_can_update_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->put('/api/categories/' . $category->id, [
            'name' => [
                'en' => 'Category Name',
                'ar' => 'اسم الفئة'
            ],
           
        ]);
     //   dd($response->json());
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Category::all());

        // $this->assertDatabaseHas('categories', [
        //     'name' => [
        //         'en' => 'Category Name',
        //         'ar' => 'اسم الفئة'
        //     ],     
        // ]);
    }

    public function test_it_can_delete_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->delete('/api/categories/' . $category->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Category::all());
    }

    public function test_it_can_get_a_category()
    {
        $category = Category::factory()->create();
        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Category::all());
    }

    public function test_it_can_get_all_categories()
    {
        Category::factory()->create();
        $response = $this->get('/api/categories');
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Category::all());
    }

    


}
