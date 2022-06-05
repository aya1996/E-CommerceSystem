<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use App\Models\Size as ModelsSize;
use Illuminate\Http\Request;

class Size extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->handleResponse(SizeResource::collection(ModelsSize::all()), 200);
        //return category::all();
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
            'name' => 'required|string|max:255',


        ]);

        $size = new Size();
        $size->name = $request->name;
        $size->code = $request->code;
        $size->save();

        return $this->handleResponse(new SizeResource($size), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $size = ModelsSize::find($id);
        if ($size) {
            return $this->handleResponse(new SizeResource($size), 200);
        } else {
            return $this->handleError('Size not found', [], 404);
        }
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

        $this->validate($request, [
            'name' => 'required|string|max:255',

        ]);

        $size = ModelsSize::find($id);
        if ($size) {
            $size->name = $request->name;
            $size->code = $request->code;
            $size->save();
            return $this->handleResponse(new SizeResource($size), 200);
        } else {
            return $this->handleError('Size not found', [], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $size = ModelsSize::find($id);
        if ($size) {
            $size->delete();
            return $this->handleResponse(new SizeResource($size), 200);
        } else {
            return $this->handleError('Size not found', [], 404);
        }
    }
}
