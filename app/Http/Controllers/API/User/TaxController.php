<?php

namespace App\Http\Controllers\API\User;

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
}
