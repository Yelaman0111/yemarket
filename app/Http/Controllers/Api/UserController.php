<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ShopResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\OrderPivot;
use App\Models\ProductCompany;
use App\Models\User;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CompanyService;
use App\Services\OrderService;
use App\Services\ProductCompanyService;
use App\Services\ProductService;
use App\Services\ShopService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(UserRequest $request, UserService $service)
    {
        $user = $service->storeUser($request);

        return new UserResource($user);
    }

    public function userLogin()
    {
        $credentials = request(['email', 'password']);
        $myTTL = 60 * 24 * 30; //minutes

        JWTAuth::factory()->setTTL($myTTL);

        if (!$token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user)
    {

        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }


    public function getAllCompanies()
    {
        return new CompanyResource(Company::withCount('products')->withCount('orders')->paginate());
    }

    public function blockCompany(Request $request, $id, CompanyService $service, ProductCompanyService $productService)
    {

        $productService->blockProductsCompany($request->block_status, $id);

        return new CompanyResource($service->changeBlockStatus($request->block_status, $id));
    }


    public function getCompaniesProducts($id)
    {
        return ProductResource::collection(ProductCompany::where('company_id', $id)->with('product')->paginate());
    }

    public function approveCompaniesProducts(Request $request, $id, ProductCompanyService $service)
    {
        return  new ProductResource($service->changeApprovedStatus($id, $request->approved_status));
    }

    public function getCompaniesOrders($id, OrderService $service)
    {
        return OrderResource::collection($service->getCompanyOrders($id));
    }

    public function getAllCategories(CategoryService $service)
    {
        return CategoryResource::collection($service->getAllCategories());
    }

    public function getParentCategories(CategoryService $service)
    {
        return CategoryResource::collection($service->getParentCategories());
    }

    public function updateCategory(CategoryRequest $request, $id, CategoryService $service)
    {
        $service->update($request, $id);
    }

    public function createCategory(CategoryRequest $request, CategoryService $service)
    {
        return $service->store($request);
    }


    public function getBrands(BrandService $service)
    {
        return BrandResource::collection($service->getBrands());
    }

    public function createBrand(BrandRequest $request, BrandService $service)
    {
        return $service->store($request);
    }

    public function updateBrand(BrandRequest $request, $id, BrandService $service)
    {
        return $service->update($request, $id);
    }

    public function getProducts(ProductService $service)
    {
        return ProductResource::collection($service->getAllProducts());
    }

    public function approveProduct(Request $request, $id, ProductService $service)
    {
        return  new ProductResource($service->changeApprovedStatus($request->approved_status, $id));
    }

    public function getAllShops(ShopService $service)
    {
        return ShopResource::collection($service->getAllShops());
    }

    public function blockShop(Request $request, $id, ShopService $service)
    {
        return new ShopResource($service->changeBlockStatus($request->block_status, $id));
    }

    public function getShopOrders($id, OrderService $service)
    {
        return OrderResource::collection($service->getShopOrders($id));
    }
}
