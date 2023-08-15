<?php

namespace App\Services;

use App\Http\Requests\ProductCompanyRequest;
use App\Models\ProductCompany;

class ProductCompanyService
{
    public function storeProductCompany(ProductCompanyRequest $request)
    {
        $company_id = auth()->guard('company-api')->user()->id;

        $checkExists = ProductCompany::where('company_id', $company_id)->where('product_id', $request->product_id)->first();


        if (!$checkExists) {

            $productCompany = ProductCompany::create([
                'company_id' => $company_id,
                'product_id' => $request->product_id,
                'price' => $request->price,
                'sku' => $request->sku,
                'min_order_count' => $request->min_order_count,
            ]);

            return $productCompany;
        }

        return response()->json(['error' => 'error'], 400);
    }

    public function changeApprovedStatus($product_id, $approved_status)
    {
        $productCompany = ProductCompany::find($product_id);
        $productCompany->approved = $approved_status;
        $productCompany->save();

        return  $productCompany;
    }


    public function blockProductsCompany($block_status, $id)
    {
        ProductCompany::where('company_id', '=', $id)
            ->update(['approved' => !$block_status]);
    }

    public function getCompaniesProducts($id)
    {
        ProductCompany::where('company_id', $id)->with('product')->paginate();
    }
}
