<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderResource;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Transaction;
use App\Traits\InvoiceTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller

{

    use InvoiceTrait;


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
        // return $request->validated();
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,
            'status' => $request->status,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        foreach (array_count_values($request->products) as $product_id => $count) {

            $order->products()->attach($product_id, ['quantity' => $count]);
        }
        $products = Product::whereIn('id', $request['products'])->get();
        $taxes = Tax::whereIn('id', $request['taxes'])->get();

        $invoice = $this->saveInvoice($products, $taxes);



        // return $order;

        return $this->handleResponse(new OrderResource($order), new InvoiceResource($invoice), 201);
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
            'user_id' => auth()->user()->id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,

        ]);
        foreach (array_count_values($request->products) as $product_id => $count) {

            $order->products()->sync($product_id, ['quantity' => $count]);
        }
        $products = Product::whereIn('id', $request['products'])->get();
        $taxes = Tax::whereIn('id', $request['taxes'])->get();
        $invoice = $this->saveInvoice($products, $taxes);
        return $this->handleResponse(new OrderResource($order), new InvoiceResource($invoice), __('messages.order_updated'));
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

    public function getOrdersByUser()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return $this->handleResponse(new OrderResource($orders), 200);
    }

    public function getOrdersByUserAndStatus($status)
    {
        $orders = Order::where('user_id', auth()->user()->id)->where('status', $status)->get();
        return $this->handleResponse(new OrderResource($orders), 200);
    }

    public function assignDelivery(Request $request, $id)
    {


        $order = Order::findOrFail($id);
        $order->update([
            'delivery_id' => $request->delivery_id,
        ]);
        return $this->handleResponse(__('messages.order_updated'), 200);
    }


    public function changeStatus(int $id)
    {
        // $order = Order::find($id);
        return "works";
    }

    public function assignDeliveryToOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $latitude = $order->where('id', $id)->value('latitude');
        $longitude = $order->where('id', $id)->value('longitude');

        $status = $request->status;

        $delivery_id = Delivery::Distance($latitude, $longitude)->first()->id;
        // return $delivery_id;

        $order->update([
            'delivery_id' => $delivery_id,
            'status' => $status,
        ]);
        return $this->handleResponse($order, __('messages.order_updated'), 200);
    }


    public function cancelOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $shipping_date = Carbon::parse($order->shipping_date);
        $current = Carbon::now();
        // return $shipping_date->diffInDays($current, true);

        if ($shipping_date->diffInDays($current, true) == 1) {
            return $this->handleError(__('messages.order_cannot_cancelled'));
        }
        $order->update([
            'status' => 'cancelled',
        ]);



        return $this->handleResponse($order, __('messages.order_canceled'), 200);
    }

    public function getCancelledOrders()
    {
        $orders = Order::where('status', 'cancelled')->get();
        return $this->handleResponse(new OrderResource($orders), 200);
    }
}
