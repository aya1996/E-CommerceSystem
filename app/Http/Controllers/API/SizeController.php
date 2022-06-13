<?php

namespace App\Http\Controllers\API;

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
    public function __construct()
    {
        $this->middleware('permission:view-size|create-size|edit-size|delete-size', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-size', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-size', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-size', ['only' => ['destroy']]);
    }
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
            'name.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'name.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',



        ]);

        $size = new ModelsSize();
        $size->setTranslations('name', $request->name);

        $size->save();

        return $this->handleResponse(new SizeResource($size), __('messages.size_added'), 201);
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

        ]);

        $size = ModelsSize::find($id);
        if ($size) {
            $size->setTranslations('name', $request->name);

            $size->save();
            return $this->handleResponse(new SizeResource($size), __('messages.size_updated'), 200);
        } else {
            return $this->handleError(__('messages.size_not_found'), [], 404);
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
            return $this->handleResponse(__('messages.size_deleted'), 200);
        } else {
            return $this->handleError(__('messages.size_not_found'), [], 404);
        }
    }
}
