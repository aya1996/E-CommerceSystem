<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use App\Models\Size as ModelsSize;
use Illuminate\Http\Request;

class SizeController extends Controller
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
            return $this->handleError(__('messages.size_not_found'), [], 404);
        }
    }
}
