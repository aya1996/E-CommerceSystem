<?php

namespace App\Http\Controllers\AP\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index()
    {
        return $this->handleResponse(DeliveryResource::collection(Delivery::all()), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::findOrFail($id);
        return $this->handleResponse(new DeliveryResource($delivery), 200);
    }

    
    

   
}
