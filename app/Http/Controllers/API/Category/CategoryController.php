<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $service;
    
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response(
            $this->service
                ->setAttrs($request->all())
                ->getSelectedCategory()
        );
    }

    public function create(CategoryRequest $request)
    {
        $this->service
            ->setAttrs($request->all())
            ->createCategory();

        return response(['status' => 'success', 'message' => 'Category created successfully']);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $this->service
            ->setAttrs($request->except('display_image', 'gallery_image'))
            ->setModel($category)
            ->updateCategory();

        return response(['status' => 'success', 'message' => 'Category updated successfully']);
    }

    public function delete(Category $category)
    {
        $this->service
            ->setModel($category)
            ->deleteCategory();

        return response(['status' => 'success', 'message' => 'Category deleted successfully']);
    }
}
