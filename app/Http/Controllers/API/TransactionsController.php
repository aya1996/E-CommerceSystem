<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(TransactionResource::collection(Transaction::all()), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {

        // $transaction = Transaction::create([


        //     'transaction_id' => uniqid(),
        //     'payment_method' => $request->payment_method,
        //     'payment_status' => $request->payment_status,
        //     'payment_amount' => Invoice::find(auth()->user()->id)->sub_total,
        //     'payment_currency' => $request->payment_currency,
        //     'payment_date' => $request->payment_date,

        // ]);


        $transaction = new Transaction();
        $transaction->transaction_id = uniqid();
        $transaction->payment_method = $request->payment_method;
        $transaction->payment_status = $request->payment_status;
        $transaction->payment_amount = Invoice::find(auth()->user()->id)->sub_total;
        $transaction->payment_currency = $request->payment_currency;
        $transaction->payment_date = $request->payment_date;
        $transaction->transactionable()->associate(auth()->user());
        $transaction->save();



        return $this->handleResponse(new TransactionResource($transaction), __('messages.transaction_created'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction)
            return $this->handleResponse(null, __('messages.transaction_not_found'), 404);

        return $this->handleResponse($transaction, 200);
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
        $transaction = Transaction::find($id);

        if (!$transaction)
            return $this->handleResponse(null, __('messages.transaction_not_found'), 404);

        $transaction->update([
            'user_id' => auth()->user()->id,
            'transaction_id' => uniqid(),
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'payment_amount' => Invoice::find($request->user_id)->sub_total,
            'payment_currency' => $request->payment_currency,
            'payment_date' => $request->payment_date,

        ]);


        return $this->handleResponse($transaction, __('messages.transaction_updated'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction)
            return $this->handleResponse(null, __('messages.transaction_not_found'), 404);

        $transaction->delete();

        return $this->handleResponse(null, __('messages.transaction_deleted'), 200);
    }

    public function getCanceledTransactions()
    {
        $transactions = Transaction::where('payment_status', 'refunded')->get();

        return $this->handleResponse($transactions, 200);
    }
    public function isRefunded($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction)
            return $this->handleResponse(null, __('messages.transaction_not_found'), 404);

        $transaction->update([
            'is_refunded' => 1,
            'payment_status' => 'refunded',
        ]);

        return $this->handleResponse($transaction, __('messages.transaction_refunded'), 200);
    }
}
