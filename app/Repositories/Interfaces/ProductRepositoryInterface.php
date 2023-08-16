<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\ProductRequest;

interface ProductRepositoryInterface
{
    public function storeProduct(ProductRequest $request);

    public function getCompanyProducts($company_id);

    public function getCompanyAllProducts($company_id);

    public function getApprovedProductsWithoutCompanyProducts();

    public function searchProductOfCompany($search_text, $company_id);

    public function searchProductForConnect($search_text);

    public function getAllProducts();

    public function changeApprovedStatus($approved_status, $id);

    public function getProductsByCategory($category_id);

    public function getProductsByBrand($brand_id);

    public function getProductsByCompany($company_id);

    public function searchProducts($search_text);

    public function getSpecificProduct($id);


}