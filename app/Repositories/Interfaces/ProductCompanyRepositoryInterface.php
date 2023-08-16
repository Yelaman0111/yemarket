<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\ProductCompanyRequest;

interface ProductCompanyRepositoryInterface
{
    public function storeProductCompany(ProductCompanyRequest $request, $company_id);

    public function checkExists($product_id, $company_id );

    public function changeApprovedStatus($product_id, $approved_status);

    public function getCompaniesProducts($id);

    public function getProuctCompaniesByIds($products_id);

}