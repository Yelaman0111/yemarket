<?php

namespace App\Repositories;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    public function all()
    {
        return Brand::all();
    }

    public function store(BrandRequest $request)
    {
        $brand = new Brand();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "." . $file->extension();
            $file->move(public_path('uploads/brands'), $imageName);
            $brand->image = $imageName;
        }

        $brand->name = $request->name;
        $brand->save();

        return $brand;
    }

    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "." . $file->extension();
            $file->move(public_path('uploads/brands'), $imageName);
            $brand->image = $imageName;
        }

        $brand->name = $request->name;
        $brand->save();

        return $brand;
    }

}
