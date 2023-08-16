<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\Request;

interface CompanyRepositoryInterface
{
    public function storeCompany(CompanyRequest $request);

    public function updateCompany(CompanyUpdateRequest $request);
    
    public function changeBlockStatus(Request $request, $company_id);

    public function getCompaniesForMainPage();

    public function getShoppingCart(Request $request);

    public function getAllCompanies();

}