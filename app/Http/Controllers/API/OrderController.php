<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(OrderResource::collection(Order::all()), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,


        ]);

        // return $quantity;


        // $quantity = 1;
        // $order->products()->attach($request->products, ['quantity' => $quantity]);



        // foreach ($order->products as $product) {
        //     //return $product;
        //     if ($product->pivot->product_id == $product->pivot->product_id + 1) {
        //         $product->pivot->quantity = $product->pivot->quantity + 1;
        //         $product->pivot->save();
        //     }
        // }

        // $quantity = 1;
        // $product_count = count($request->products);
        // for ($i = 1; $i < $product_count; $i++) {
        //     //return count($request->products);

        //     if ($request->products[$i] != $request->products[$i + 1]) {
        //         $quantity++;
        //         $order->products()->attach($request->products[$i], ['quantity' => $quantity]);
        //     } else {
        //         $order->products()->attach($request->products[$i++], ['quantity' => $quantity]);
        //         $quantity = 1;
        //     }
        // }

        // foreach ($order->products as $product) {
        //     if ($product->pivot->product_id == $product->pivot->product_id + 1) {
        //         $product->pivot->quantity = $product->pivot->quantity + 1;
        //         $product->pivot->save();
        //     }
        // }
        // $order->products()->attach($request->products);

        foreach (array_count_values($request->products) as $product_id => $count) {

            $order->products()->attach($product_id, ['quantity' => $count]);
        }

        return $this->handleResponse(new OrderResource($order), __('messages.order_created'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return $this->handleResponse(new OrderResource($order), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'user_id' => $request->user_id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,
            'status'  => $request->status,
        ]);

        $order->products()->sync($request->products);
        foreach ($order->products as $product) {
            if ($product->pivot->product_id == $product->pivot->product_id + 1) {
                $product->pivot->quantity = $product->pivot->quantity + 1;
                $product->pivot->save();
            }
        }

        return $this->handleResponse(new OrderResource($order), __('messages.order_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return $this->handleResponse(__('messages.order_deleted'), 204);
    }
}
