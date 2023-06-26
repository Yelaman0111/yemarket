<?php

namespace App\Http\Controllers\Api;

use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchProdutsRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CorouselResource;
use App\Http\Resources\ProductResource;
use App\Models\Company;
use App\Models\Corousel;
use App\Services\CompanyService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function getCategories(CategoryService $service)
    {
        return CategoryResource::collection($service->getCategoriesHasProducts());
    }

    public function getProductsByCategory(ProductService $service, $id)
    {
        return ProductResource::collection($service->getProductsByCategory($id));
    }

    public function getProductsByBrand(ProductService $service, $id)
    {
        return ProductResource::collection($service->getProductsByBrand($id));
    }

    public function getProductsByCompany(ProductService $service, $id)
    {
        return ProductResource::collection($service->getProductsByCompany($id));
    }

    public function searchProducts(SearchProdutsRequest $request, ProductService $service)
    {
        return ProductResource::collection($service->searchProducts($request->search_text));
    }

    public function getCompaniesForMainPage(CompanyService $service)
    {
        return CompanyResource::collection($service->getCompaniesForMainPage());
    }

    public function getCorousel()
    {
        return CorouselResource::collection(Corousel::all());
    }

    public function getSpecificProduct($id, ProductService $service)
    {
        return new ProductResource($service->getSpecificProduct($id));
    }

    public function getShoppingCart(Request $request, CompanyService $service)
    {
        return Company::whereHas('products', function ($query) use ($request) {
            $query->whereIn('id', explode(',', $request->products_id));
        })->with(['products' => function ($query) use ($request) {
            $query->whereIn('id', explode(',', $request->products_id));
            $query->with('product');
        }])
            ->get();
    }
}
