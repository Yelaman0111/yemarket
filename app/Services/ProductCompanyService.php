<?php

namespace App\Services;

use App\Http\Requests\ProductCompanyRequest;
use App\Models\ProductCompany;
use App\Repositories\Interfaces\ProductCompanyRepositoryInterface;

class ProductCompanyService
{

    private $productCompanyRepository;

    public function __construct(ProductCompanyRepositoryInterface $productCompanyRepository)
    {
        $this->productCompanyRepository = $productCompanyRepository;
    }

    public function storeProductCompany(ProductCompanyRequest $request)
    {
        $company_id = auth()->guard('company-api')->user()->id;

        $checkExists = $this->productCompanyRepository->checkExists($request->product_id, $company_id);

        if (!$checkExists) {
            return $this->productCompanyRepository->storeProductCompany($request, $company_id);
        }

        return response()->json(['error' => 'error'], 400);
    }

    public function changeApprovedStatus($product_id, $approved_status)
    {
        return $this->productCompanyRepository->changeApprovedStatus($product_id, $approved_status);
    }

    public function blockProductsCompany($block_status, $id)
    {
        $this->productCompanyRepository->changeApprovedStatus($id, !$block_status);
    }

    public function getCompaniesProducts($id)
    {
       return $this->productCompanyRepository->getCompaniesProducts($id);
    }
}
