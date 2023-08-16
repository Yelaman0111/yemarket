<?php

namespace App\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function store(CategoryRequest $request)
    {
        $category = new Category();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "." . $file->extension();
            $file->move(public_path('uploads/category'), $imageName);
            $category->image = $imageName;
        }

        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->save();

        return $category;
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "." . $file->extension();
            $file->move(public_path('uploads/category'), $imageName);
            $category->image = $imageName;
        }

        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->save();

        return $category;
    }

    public function getCategoriesHasProducts()
    {
        return Category::where('parent_id', 0)
            ->whereHas('childCategories', function ($q) {
                $q->whereHas('products', function ($q) {
                    $q->whereHas('companiesProduct');
                });
            })->with('childCategories', function ($q) {
                $q->whereHas('products', function ($q) {
                    $q->whereHas('companiesProduct');
                });
            })->get();
    }

    public function getCategoriesAll()
    {
        return Category::where('parent_id', 0)
            ->whereHas('childCategories')
            ->with('childCategories')->get();
    }


    public function getAllCategories()
    {
        return Category::where('parent_id', 0)
            ->with('childCategories', function ($q) {
                $q->withCount('products');
            })->get();
    }

    public function getParentCategories()
    {
        return Category::where('parent_id', 0)->get();
    }
}
