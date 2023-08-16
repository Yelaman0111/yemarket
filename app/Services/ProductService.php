<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCompany;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use GuzzleHttp\Psr7\Request;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function storeProduct(ProductRequest $request)
    {
        return $this->productRepository->storeProduct($request);
    }

    public function getCompanyProducts($company_id)
    {
        return $this->productRepository->getCompanyProducts($company_id);
    }

    public function getCompanyAllProducts()
    {
        $company_id = auth()->guard('company-api')->user()->id;

        return $this->productRepository->getCompanyAllProducts($company_id);
    }

    public function getApprovedProductsWithoutCompanyProducts()
    {
        return $this->productRepository->getApprovedProductsWithoutCompanyProducts();
    }

    public function searchProductOfCompany($search_text)
    {
        $company_id = auth()->guard('company-api')->user()->id;

        return $this->productRepository->searchProductOfCompany($search_text, $company_id);
    }

    public function searchProductForConnect($search_text)
    {
        if ($search_text != '') {
            return $this->productRepository->searchProductForConnect($search_text);
        } else {
            return response()->noContent();
        }
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function changeApprovedStatus($approved_status, $id)
    {
        return $this->productRepository->changeApprovedStatus($approved_status, $id);
    }

    public function getProductsByCategory($category_id)
    {
        return $this->productRepository->getProductsByCategory($category_id);
    }

    public function getProductsByBrand($brand_id)
    {
        return $this->productRepository->getProductsByBrand($brand_id);
    }

    public function getProductsByCompany($company_id)
    {
        return $this->productRepository->getProductsByCompany($company_id);
    }

    public function searchProducts($search_text)
    {
        return $this->productRepository->searchProducts($search_text);
    }

    public function getSpecificProduct($id)
    {
        return $this->productRepository->getSpecificProduct($id);
    }
}
