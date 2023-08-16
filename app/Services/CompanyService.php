<?php

namespace App\Services;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class CompanyService
{
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
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
    
    public function storeCompany(CompanyRequest $request)
    {
        return $this->companyRepository->storeCompany($request);
    }

    public function updateCompany(CompanyUpdateRequest $request)
    {
        return $this->companyRepository->updateCompany($request);
    }

    public function changeBlockStatus(Request $request, $company_id, ProductCompanyService $productService)
    {
        $productService->blockProductsCompany($request->block_status, $company_id);

        return  $this->companyRepository->changeBlockStatus($request, $company_id);
    }

    public function getCompaniesForMainPage()
    {
        return  $this->companyRepository->getCompaniesForMainPage();
    }

    public function getShoppingCart(Request $request)
    {
        return  $this->companyRepository->getShoppingCart($request);
    }

    public function getAllCompanies()
    {
        return  $this->companyRepository->getAllCompanies();
    }
}
