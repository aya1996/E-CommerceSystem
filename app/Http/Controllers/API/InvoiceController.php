<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(InvoiceResource::collection(Invoice::all()), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {

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

        $invoice = Invoice::create([
            'invoice_number' => uniqid(),
            'total_amount' => $total,
            'user_id' => auth()->user()->id,
            'sub_total' => $sub_total,
            'discount' =>  $discount,
            'invoiceDate' => Date('Y-m-d'),

        ]);

        $invoice->products()->attach($request->products);
        $invoice->taxes()->attach($request->taxes);

        return $this->handleResponse(new InvoiceResource($invoice), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return $this->handleResponse(new InvoiceResource($invoice), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(
            [
                'user_id' => auth()->user()->id,
                'invoiceDate' => $request->invoiceDate,
                'status' =>  $request->status,
            ]
        );

        $invoice->products()->sync($request->products);
        $invoice->taxes()->sync($request->taxes);

        return $this->handleResponse(new InvoiceResource($invoice), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return $this->handleResponse(__('messages.invoice_deleted'), 200);
    }
}
