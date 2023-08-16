<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function store(CategoryRequest $request)
    {
        return $this->categoryRepository->store($request);
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->categoryRepository->update($request, $id);
    }

    public function getCategoriesHasProducts()
    {
        return $this->categoryRepository->getCategoriesHasProducts();
    }

    public function getCategoriesAll()
    {
        return $this->categoryRepository->getCategoriesAll();
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function getParentCategories()
    {
        return $this->categoryRepository->getParentCategories();
    }
}
