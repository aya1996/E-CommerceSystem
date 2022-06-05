<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->handleResponse(CategoryResource::collection(Category::all()), 200);
        //return category::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',

        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return $this->handleResponse(new CategoryResource($category), 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $this->handleResponse(new CategoryResource($category), 200);
        } else {
            return $this->handleError('Category not found', [], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',

        ]);

        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->save();
            return $this->handleResponse(new CategoryResource($category), 200);
        } else {
            return $this->handleError('Category not found', [], 404);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->handleResponse(new CategoryResource($category), 200);
        } else {
            return $this->handleError('Category not found', [], 404);
        }
    }
}
