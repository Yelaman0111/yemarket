<?php

namespace App\Services;

use App\Http\Requests\BrandRequest;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandService
{
    private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function store(BrandRequest $request)
    {
        return $this->brandRepository->store($request);
    }

    public function update(BrandRequest $request, $id)
    {
        return $this->brandRepository->update($request, $id);
    }

    public function getBrands()
    {
        return $this->brandRepository->all();
    }
}
