<?php

namespace App\Http\Controllers\API;

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


    public function __construct()
    {
        $this->middleware('permission:view-delivery|create-delivery|edit-delivery|delete-delivery', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-delivery', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-delivery', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-delivery', ['only' => ['destroy']]);
    }




    public function index()
    {
        return $this->handleResponse(DeliveryResource::collection(Delivery::all()), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $delivery = Delivery::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return $this->handleResponse(new DeliveryResource($delivery), 201);
    }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryRequest $request, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);


        return $this->handleResponse(new DeliveryResource($delivery), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();
        return $this->handleResponse(new DeliveryResource($delivery), 200);
        
    }

   
}
