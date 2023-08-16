<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\BrandRequest;

interface BrandRepositoryInterface
{
    public function all();

    public function store(BrandRequest $request);

    public function update(BrandRequest $request, $id);

}