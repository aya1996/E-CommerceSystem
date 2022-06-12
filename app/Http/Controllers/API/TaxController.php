<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(Tax::all(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'name.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'rate' => 'required | numeric',

        ]);
        $tax = Tax::create(
            [
                'name'  => [
                    'en' => $request->name,
                    'ar' => $request->name,

                ],
                'rate' => $request->rate,
            ]
        );

        return $this->handleResponse($tax, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tax = Tax::find($id);
        if (!$tax) {
            return $this->handleResponse(__('messages.tax_not_found'), 404);
        }
        return $this->handleResponse($tax, 200);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tax $tax)
    {
        $this->validate($request, [
            'name.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'name.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'rate' => 'required | numeric',

        ]);
        $tax->update($request->all());
        return $this->handleResponse($tax, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $tax = Tax::find($id);
        if (!$tax) {
            return $this->handleResponse(__('messages.tax_not_found'), 404);
        }
        $tax->delete();
        return $this->handleResponse(__('messages.tax_deleted'), 200);
    }
}
