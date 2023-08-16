<?php

namespace App\Repositories;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\ProductCompany;
use App\Repositories\Interfaces\ProductCompanyRepositoryInterface;

class ProductCompanyRepository implements ProductCompanyRepositoryInterface
{
    public function storeProductCompany($request, $company_id)
    {
        return ProductCompany::create([
            'company_id' => $company_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'sku' => $request->sku,
            'min_order_count' => $request->min_order_count,
        ]);
    }

    public function checkExists($product_id, $company_id)
    {
        return ProductCompany::where('company_id', $company_id)->where('product_id', $product_id)->first();
    }

    public function changeApprovedStatus($product_id, $approved_status)
    {
        $productCompany = ProductCompany::find($product_id);
        $productCompany->approved = $approved_status;
        $productCompany->save();

        return  $productCompany;
    }

    public function getCompaniesProducts($id)
    {
        return ProductCompany::where('company_id', $id)->with('product')->paginate();
    }

    public function getProuctCompaniesByIds($products_id)
    {
        return  ProductCompany::whereIn('id', $products_id)->with('company')->get();
    }
}
