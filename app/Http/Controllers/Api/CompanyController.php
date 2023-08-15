<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\ProductCompanyRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\SearchProdutsRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Services\CategoryService;
use App\Services\CompanyService;
use App\Services\OrderService;
use App\Services\ProductCompanyService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(CompanyRequest $request, CompanyService $service)
    {
        return new CompanyResource($service->storeCompany($request));
    }

    public function companyLogin(CompanyService $service)
    {
        return $service->companyLogin();
    }

    public function show()
    {
        return new CompanyResource(auth()->guard('company-api')->user());
    }

    public function update(CompanyUpdateRequest $request, CompanyService $service)
    {
        return $service->updateCompany($request);
    }

    public function getCompanyAllProducts(ProductService $service)
    {
        return new ProductResource($service->getCompanyAllProducts());
    }

    public function getApprovedProductsWithoutCompanyProducts(ProductService $service)
    {
        return new ProductResource($service->getApprovedProductsWithoutCompanyProducts());
    }

    public function getAllCategories(CategoryService $service)
    {
        return CategoryResource::collection($service->getCategoriesAll());
    }

    public function getAllBrands()
    {
        return BrandResource::collection(Brand::all());
    }

    public function storeProduct(ProductRequest $request, ProductService $service)
    {
        return new ProductResource($service->storeProduct($request));
    }

    public function connectToProduct(ProductCompanyRequest $request, ProductCompanyService $service)
    {
        $service->storeProductCompany($request);

        response()->json(['success' => 'success'], 200);
    }

    public function searchProductOfCompany(SearchProdutsRequest $request, ProductService $service)
    {
        return $service->searchProductOfCompany($request->search_text);
    }

    public function searchProductForConnect(Request $request, ProductService $service)
    {
        return $service->searchProductForConnect($request->search_text);
    }

    public function getCompanyOrders(OrderService $service)
    {
        return OrderResource::collection($service->getCompanyOrders());
    }

    public function ordersAccept(Request $request, OrderService $service)
    {
        return  $service->acceptOrder($request);
    }

    public function downloadOrder($order_id, OrderService $service)
    {
        return $service->downloadOrder($order_id);
    }
}
