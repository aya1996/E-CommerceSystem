<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // use RefreshDatabase;


    public function test_it_can_create_a_product()
    {
        Storage::fake('local');
        $admin = Admin::find(1);
        // $admin->givePermissionTo('create-product');
        $response =  $this->actingAs($admin)->post('/api/product', [
            'name' => [
                'en' => 'Product Name',
                'ar' => 'اسم المنتج'
            ],
            'price' => 100,
            'description' => ['en' => 'Description 1', 'ar' => ' وصف 1'],
            'feature_image' => UploadedFile::fake()->image('file.jpg'),
            'categories' => [1, 2],
            'colors' => [1, 2],
            'sizes' => [1, 2],
            'images' => [UploadedFile::fake()->image('file.jpg')]
            // 'images' => [$this->createImage(), $this->createImage()]


        ]);
        //dd($response->json());
        $response->assertStatus(200);
        // $this->assertCount(1, Product::all());
        // $this->assertDatabaseHas('products', [
        //     'name' => [
        //         'en' => 'Product Name',
        //         'ar' => 'اسم المنتج'
        //     ],
        //     'price' => 100,
        //     'description' => ['en' => 'Description 1', 'ar' => ' وصف 1'],
        //     'feature_image' => UploadedFile::fake()->create('file.jpg'),
        //     'categories' => [1, 2],
        //     'colors' => [1, 2],
        //     'sizes' => [1, 2],
        //     'images' => [UploadedFile::fake()->create('file.jpg')]


        // ]);
    }

    public function test_it_can_update_a_product()
    {
        $admin = Admin::find(1);
        $product = Product::factory()->create();
        $response = $this->actingAs($admin)->put('/api/products/' . $product->id, [
            'name' => [
                'en' => 'Product Name',
                'ar' => 'اسم المنتج'
            ],
            'price' => 100,
            'description' => ['en' => 'Description 1', 'ar' => ' وصف 1'],
            'feature_image' => UploadedFile::fake()->image('file.jpg'),
            'categories' => [1, 2],
            'sizes' => [1, 2],
            'colors' => [1, 2],
            'images' => [UploadedFile::fake()->image('file.jpg')]
        ]);
        //dd($response->json());
        $response->assertStatus(200);
    }

    public function test_it_can_delete_a_product()
    {
        $product = Product::factory()->create();
        $admin = Admin::find(1);
        $response = $this->actingAs($admin)->delete('/api/products/' . $product->id);

        $response->assertStatus(200);
    }

    public function test_it_can_get_a_product()
    {
        $product = Product::factory()->create();
        $admin = Admin::find(1);
        $response = $this->actingAs($admin)->get('/api/products/' . $product->id);

        $response->assertStatus(200);
    }

    // public function test_it_can_get_all_products()
    // {
    //     // $product = Product::factory()->create();
    //     $admin = Admin::find(1);
    //     $response = $this->actingAs($admin)->get('/api/products');

    //     $response->assertStatus(200);
    // }
}
