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
        $productCategory = Product::query()->when(request('category_id'), function ($query) {
            return $query->whereHas('categories', function ($query) {
                return $query->where('category_id', request('category_id'));
            });
        })->when(request('size_id'), function ($query) {
            return $query->whereHas('sizes', function ($query) {
                return $query->where('size_id', request('size_id'));
            });
        })->when(request('color_id'), function ($query) {
            return $query->whereHas('colors', function ($query) {
                return $query->where('color_id', request('color_id'));
            });
        })->when(request('price'), function ($query) {
            return $query->where('price', '>=', request('price'));
        })->when(request('price_to'), function ($query) {
            return $query->where('price', '<=', request('price_to'));
        })->paginate(5);

        return ProductResource::collection($productCategory);

        // return $this->handleResponse(ProductResource::collection(Product::all()), 200);
    }

    public function show($id)
    {
        return $this->handleResponse(new ProductResource(Product::find($id)), 200);
    }

    public function store(ProductRequest $request)
    {
        // return $request->all();
        // return $request->name['ar'];
        $product = new Product();
        $product->setTranslations('name', $request->name);
        // $product->setTranslations('name', $request->name['ar']);

        // return $product;

        $product->price = $request->price;
        $product->setTranslations('description', $request->description);
        // $product->description->setTranslations('ar', $request->description);

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
                File::delete(public_path('images/' . $product->feature_image));
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



    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->keyword . '%')->get();
        return $this->handleResponse(ProductResource::collection($products), 200);
    }
}


/*
         $product = Product::create([
            'name'  => [
                'en' => $request->name,
                'ar' => $request->name,
            
            ]
        ]);
 */