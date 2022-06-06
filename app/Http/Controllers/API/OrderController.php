<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,
            'status' => $request->status,
        ]);
      
 
        $quantity =0;
        if($request->products){
            foreach($request->products as $product){
                $quantity += $product['quantity'];
            }
        }
        $order->products()->attach($request->products);
      if($order->products->id)
      


        return $this->handleResponse(new OrderResource($order), 201);
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
        $order->update($request->all());
        $order->products()->sync($request->products);
        return $this->handleResponse(new OrderResource($order), 200);
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
