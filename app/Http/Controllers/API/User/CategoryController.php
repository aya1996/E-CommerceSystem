<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
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


    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $this->handleResponse(new CategoryResource($category), 200);
        } else {
            return $this->handleError(__('messages.category_not_found'), [], 404);
        }
    }

    
}
