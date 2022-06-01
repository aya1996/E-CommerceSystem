<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index()
    {
        return $this->handleResponse(ProductResource::collection(Product::all()), 200);
    }

    public function show($id)
    {
        return Product::find($id);
    }

    public function store(ProductRequest $request)
    {


        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        $product->save();
        if ($request->hasfile('image')) {
            //$name = $this->saveImage($request->image);
            // $book->image = $name;
            $image = $request->file('image');
            $name =  mt_rand() . '.' . $image->getClientOriginalExtension();


            $image->move(public_path() . '/images/', $name);
        }
        $product->image = $name;
        $product->save();

        $product->categories()->attach($request->category_id);

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

            if ($request->hasfile('image')) {
                //$name = $this->saveImage($request->image);
                // $book->image = $name;
                $image = $request->file('image');
                $name =  mt_rand() . '.' . $image->getClientOriginalExtension();
            }
            $product->image = $name;
            $product->save();
            $product->categories()->sync($request->category_id);

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
            return $this->handleResponse('Product deleted successfully', 200);
        } else {
            return $this->handleError('Product not found', [], 404);
        }
    }
}
