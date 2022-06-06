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

        return $this->handleResponse(new ProductResource($product), __('messages.product_added'), 201);
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

            return $this->handleResponse(new ProductResource($product), __('messages.product_updated'), 200);
        } else {
            return $this->handleError(__('messages.product_not_found'), [], 404);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            File::delete(public_path('images/' . $product->feature_image));
            File::delete(public_path('images/' . $product->images));
            return $this->handleResponse(__('messages.product_deleted_successfully'), 200);
        } else {
            return $this->handleError(__('messages.product_not_found'), [], 404);
        }
    }



    public function search(Request $request)
    {
        if ($request->keyword) {
            $products = Product::where('name', 'LIKE', '%' . $request->keyword . '%')->get();
            return $this->handleResponse(ProductResource::collection($products), __('messages.product_found'), 200);
        }
        return $this->handleError(__('messages.product_not_found'), [], 404);
    }
    // public function addToCart($id)
    // {
    //     $product = Product::find($id);
    //     if ($product) {
    //         $cart = session()->get('cart');
    //         if (!$cart) {
    //             $cart = [
    //                 $id => [
    //                     "name" => $product->name,
    //                     "quantity" => 1,
    //                     "price" => $product->price,
    //                     "image" => $product->feature_image
    //                 ]
    //             ];
    //             session()->put('cart', $cart);
    //             return $this->handleResponse($cart, __('messages.product_added_to_cart'), 200);
    //         }
    //         if (isset($cart[$id])) {
    //             $cart[$id]['quantity']++;
    //             session()->put('cart', $cart);
    //             return $this->handleResponse($cart, __('messages.product_added_to_cart'), 200);
    //         } else {
    //             $cart[$id] = [
    //                 "name" => $product->name,
    //                 "quantity" => 1,
    //                 "price" => $product->price,
    //                 "image" => $product->feature_image
    //             ];
    //             session()->put('cart', $cart);
    //             return $this->handleResponse($cart, __('messages.product_added_to_cart'), 200);
    //         }
    //     } else {
    //         return $this->handleError(__('messages.product_not_found'), [], 404);
    //     }
    // }

    // public function getCart()
    // {
    //     if (session()->has('cart')) {
    //         $cart = session()->get('cart');
    //         return $this->handleResponse($cart, __('messages.product_found'), 200);
    //     }
    //     return $this->handleError(__('messages.product_not_found'), [], 404);
    // }

    // public function removeFromCart($id)
    // {
    //     if (session()->has('cart')) {
    //         $cart = session()->get('cart');
    //         if (isset($cart[$id])) {
    //             unset($cart[$id]);
    //             session()->put('cart', $cart);
    //             return $this->handleResponse($cart, __('messages.product_removed_from_cart'), 200);
    //         }
    //     }
    //     return $this->handleError(__('messages.product_not_found'), [], 404);
    // }
    // public function checkout()
    // {
    //     if (session()->has('cart')) {
    //         $cart = session()->get('cart');
    //         $total = 0;
    //         foreach ($cart as $item) {
    //             $total += $item['price'] * $item['quantity'];
    //         }
    //         return $this->handleResponse($total, __('messages.total_price'), 200);
    //     }
    //     return $this->handleError(__('messages.product_not_found'), [], 404);
    // }
}



/*
         $product = Product::create([
            'name'  => [
                'en' => $request->name,
                'ar' => $request->name,
            
            ]
        ]);
 */

