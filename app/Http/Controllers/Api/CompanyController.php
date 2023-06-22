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
use App\Models\Company;
use App\Models\ProductCompany;
use App\Services\CategoryService;
use App\Services\CompanyService;
use App\Services\OrderService;
use App\Services\ProductCompanyService;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{
    public function store(CompanyRequest $request, CompanyService $service)
    {
        $company = $service->storeCompany($request);
        return new CompanyResource($company);
    }

    public function companyLogin()
    {
        $credentials = request(['email', 'password']);
        $myTTL = 60 * 24 * 30; //minutes

        JWTAuth::factory()->setTTL($myTTL);
        if (!$token = auth()->guard('company-api')->attempt($credentials, ['exp' => Carbon::now()->addDays(30)->timestamp])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
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
        $company_id = auth()->guard('company-api')->user()->id;

        $products = $service->getCompanyAllProducts($company_id);

        return new ProductResource($products);
    }

    public function getApprovedProductsWithoutCompanyProducts(ProductService $service)
    {
        $products = $service->getApprovedProductsWithoutCompanyProducts();

        return new ProductResource($products);
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
        $company_id = auth()->guard('company-api')->user()->id;

        $service->storeProductCompany($request,  $company_id);

        response()->json(['success' => 'success'], 200);
    }

    public function searchProductOfCompany(SearchProdutsRequest $request, ProductService $service)
    {
        $company_id = auth()->guard('company-api')->user()->id;
        return $service->searchProductOfCompany($request->search_text, $company_id);
    }

    public function searchProductForConnect(Request $request, ProductService $service)
    {
        if ($request->search_text != '') {
            return $service->searchProductForConnect($request->search_text);
        } else {
            return response()->noContent();
        }
    }

    public function getCompanyOrders(Request $request, OrderService $service)
    {
        $company_id = auth()->guard('company-api')->user()->id;

        return OrderResource::collection($service->getCompanyOrders($company_id));
    }

    public function ordersAccept(Request $request, OrderService $service)
    {
        $company_id = auth()->guard('company-api')->user()->id;
        $order_id = $request->id;

        return  $service->acceptOrder($order_id, $company_id);
    }

    public function downloadOrder($order_id, OrderService $service)
    {
        $company_id = auth()->guard('company-api')->user()->id;

        return $service->downloadOrder($order_id, $company_id);
        // return $service->downloadOrder($order_id, $company_id);
    }
}
