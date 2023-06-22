<?php

namespace App\Services;

use App\Http\Requests\BrandRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Brand;
use App\Models\Category;

class BrandService
{

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



    public function getBrands()
    {
        return Brand::all();
    }

}
