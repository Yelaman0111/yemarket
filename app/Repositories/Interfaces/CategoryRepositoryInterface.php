<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CategoryRequest;

interface CategoryRepositoryInterface
{
    public function store(CategoryRequest $request);

    public function update(CategoryRequest $request, $id);

    public function getCategoriesHasProducts();

    public function getCategoriesAll();

    public function getAllCategories();

    public function getParentCategories();

}