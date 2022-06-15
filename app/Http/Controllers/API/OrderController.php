<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tax;
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
            'user_id' => auth()->user()->id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,


        ]);

        foreach (array_count_values($request->products) as $product_id => $count) {

            $order->products()->attach($product_id, ['quantity' => $count]);
        }

        $products = Product::whereIn('id', $request['products'])->get();

        $total = $products->sum->price;

        $taxes = Tax::whereIn('id', $request['taxes'])->get();
        $totalTax = $taxes->sum->rate * ($total / 100);

        $discount = 0;

        if ($products->count() >= 5) {
            $discount = ($total * 10) / 100;
            $sub_total = $total - $discount + $totalTax;
        } else {
            $sub_total = $total + $totalTax;
        }

        $invoice = Invoice::create(
            [
                'invoice_number' => uniqid(),
                'total_amount' => $total,
                'user_id' => auth()->user()->id,
                'sub_total' => $sub_total,
                'discount' =>  $discount,
                'invoiceDate' => getdate()['year'] . '-' . getdate()['mon'] . '-' . getdate()['mday'],
            ]
        );
        $invoice->products()->attach($request->products);
        $invoice->taxes()->attach($request->taxes);

        // return $order;

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
            'user_id' => auth()->user()->id,
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
