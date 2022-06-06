<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorResource;
use App\Models\Color as ModelsColor;
use Illuminate\Http\Request;

class Color extends Controller
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
            'code' => 'required|string|max:255',

        ]);

        $color = new Color();
        $color->setTranslations('name', $request->name);
        $color->code = $request->code;
        $color->save();

        return $this->handleResponse(new ColorResource($color), __('messages.color_added'), 201);
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
            'name.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'name.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'code' => 'required|string|max:255',

        ]);

        $color = ModelsColor::find($id);
        if ($color) {
            $color->setTranslations('name', $request->name);
            $color->code = $request->code;
            $color->save();
            return $this->handleResponse(new ColorResource($color), 200);
        } else {
            return $this->handleError(__('messages.color_not_found'), [], 404);
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
        $color = ModelsColor::find($id);
        if ($color) {
            $color->delete();
            return $this->handleResponse(null, __('messages.color_deleted'), 200);
        } else {
            return $this->handleError(_('messages.color_not_found'), [], 404);
        }
    }
}
