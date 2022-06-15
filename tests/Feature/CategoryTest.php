<?php

namespace Tests\Feature;

use App\Models\Admin;
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
        $admin = Admin::find(1);
        $response = $this->actingAs($admin)->post('/api/category', [
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
        $admin = Admin::find(1);
        $category = Category::factory()->create();
        $response = $this->actingAs($admin)->put('/api/categories/' . $category->id, [
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
        $admin = Admin::find(1);
        $category = Category::factory()->create();
        $response = $this->actingAs($admin)->delete('/api/categories/' . $category->id);
        $response->assertStatus(200);
        // $this->assertCount(0, \App\Models\Category::all());
    }

    public function test_it_can_get_a_category()
    {
        $admin = Admin::find(1);
        $category = Category::factory()->create();
        $response = $this->actingAs($admin)->get('/api/categories/' . $category->id);
        $response->assertStatus(200);
        // $this->assertCount(1, \App\Models\Category::all());
    }

    // public function test_it_can_get_all_categories()
    // {
    //     Category::factory()->create();
    //     $response = $this->get('/api/categories');
    //     $response->assertStatus(200);
    //     // $this->assertCount(1, \App\Models\Category::all());
    // }
}
