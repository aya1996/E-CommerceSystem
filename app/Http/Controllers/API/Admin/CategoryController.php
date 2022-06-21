<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-category|create-category|edit-category|delete-category', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }
    public function index()
    {
        return $this->handleResponse(CategoryResource::collection(Category::all()), 200);
        //return category::all();
    }

    public function store(CategoryRequest $request)
    {


        $category = new Category();
        $category->setTranslations('name', $request->name);
        $category->save();

        return $this->handleResponse(new CategoryResource($category), __('messages.category_added'), 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $this->handleResponse(new CategoryResource($category), 200);
        } else {
            return $this->handleError(__('messages.category_not_found'), [], 404);
        }
    }

    public function update(CategoryRequest $request, $id)
    {


        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->save();
            return $this->handleResponse(new CategoryResource($category), __('messages.category_updated'), 200);
        } else {
            return $this->handleError(__('messages.category_not_found'), 404);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->handleResponse(null, __('messages.category_deleted'), 200);
        } else {
            return $this->handleError(__('messages.category_not_found'), [], 404);
        }
    }
}
