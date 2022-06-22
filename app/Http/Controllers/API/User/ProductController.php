<?php

namespace App\Http\Controllers\API\User;

use App\Actions\CategoryFilter;
use App\Actions\ColorFilter;
use App\Actions\NameFilter;
use App\Actions\PriceFilter;
use App\Actions\SizeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Illuminate\Pipeline\Pipeline;
use Illuminate\products\products;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    use ImageTrait;



    public function index()
    {
        // $productCategory = Product::query()->when(request('category_id'), function ($query) {
        //     return $query->whereHas('categories', function ($query) {
        //         return $query->where('category_id', request('category_id'));
        //     });
        // })->when(request('size_id'), function ($query) {
        //     return $query->whereHas('sizes', function ($query) {
        //         return $query->where('size_id', request('size_id'));
        //     });
        // })->when(request('color_id'), function ($query) {
        //     return $query->whereHas('colors', function ($query) {
        //         return $query->where('color_id', request('color_id'));
        //     });
        // })->when(request('price'), function ($query) {
        //     return $query->where('price', '>=', request('price'));
        // })->when(request('price_to'), function ($query) {
        //     return $query->where('price', '<=', request('price_to'));
        // })->paginate(5);

        // return ProductResource::collection($productCategory);


        $products = app(Pipeline::class)
            ->send(Product::query())
            ->through([
                CategoryFilter::class,
                SizeFilter::class,
                ColorFilter::class,
                PriceFilter::class,
                NameFilter::class,


            ])
            ->thenReturn()
            ->get();





        return  ProductResource::collection($products);





        // return $this->handleResponse(ProductResource::collection(Product::all()), 200);


    }

    public function show($id)
    {
        return $this->handleResponse(new ProductResource(Product::find($id)), 200);
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
