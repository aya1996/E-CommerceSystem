<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        return $this->handleResponse(ProductResource::collection(Product::all()), 200);
    }

    public function show($id)
    {
        return $this->handleResponse(new ProductResource(Product::find($id)), 200);
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasfile('feature_image')) {
            $name = $this->saveImage($request->file('feature_image'));
            $product->feature_image = $name;
        }
        $product->save();
        if ($request->hasfile('images')) {

            foreach ($request->file('images') as $image) {
                $images[] = $this->saveImages($image);
            }

            $image = new Image();
            $image->path = json_encode($images);
            $image->product_id = $product->id;
        }
        $image->save();

        $product->categories()->attach($request->categories);
        $product->colors()->attach($request->colors);
        $product->sizes()->attach($request->sizes);

        return $this->handleResponse(new ProductResource($product), 201);
    }

    public function update(ProductRequest $request, $id)
    {


        $product = Product::find($id);
        if ($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;

            $product->save();

            if ($request->hasfile('feature_image')) {
                File::delete(public_path('images/' . $product-> feature_image));
                $image = $request->file('feature_image');
                $name = $this->saveImage($image);
                $product->feature_image = $name;
            }
            $product->save();

            if ($request->hasfile('images')) {
                File::delete(public_path('images/' . $product->images));
                foreach ($request->file('images') as $image) {
                    // $name = $image->getClientOriginalName();
                    $images[] = $this->saveImages($image);
                }

                $image = new Image();
                $image->path = json_encode($images);
                $image->product_id = $product->id;
            }


            $product->categories()->sync($request->categories);
            $product->colors()->sync($request->colors);
            $product->sizes()->sync($request->sizes);

            return $this->handleResponse(new ProductResource($product), 200);
        } else {
            return $this->handleError('Product not found', [], 404);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            File::delete(public_path('images/' . $product->feature_image));
            File::delete(public_path('images/' . $product->images));
            return $this->handleResponse('Product deleted successfully', 200);
        } else {
            return $this->handleError('Product not found', [], 404);
        }
    }
}
