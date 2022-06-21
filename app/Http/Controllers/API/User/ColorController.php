<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorResource;
use App\Models\Color as ModelsColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {

        return $this->handleResponse(ColorResource::collection(ModelsColor::all()), 200);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $color = ModelsColor::find($id);
        if ($color) {
            return $this->handleResponse(new ColorResource($color), 200);
        } else {
            return $this->handleError(__('messages.color_not_found'), [], 404);
        }
    }

    
    
}
