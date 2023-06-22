<?php

namespace App\Services;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\ProductCompany;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;

class CompanyService
{

    public function storeCompany(CompanyRequest $request)
    {
        $company = new Company();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "." . $file->extension();
            $file->move(public_path('uploads/companies'), $imageName);
            $company->image = $imageName;
        }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->password = Hash::make($request->password);
        $company->phone = $request->phone;
        $company->min_order_sum = $request->min_order_sum;
        $company->save();

        return $company;
    }


    public function updateCompany(CompanyUpdateRequest $request)
    {
        $company = Company::find(auth()->guard('company-api')->user()->id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "." . $file->extension();
            $file->move(public_path('uploads/companies'), $imageName);
            $company->image = $imageName;
        }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->password = Hash::make($request->password);
        $company->phone = $request->phone;
        $company->min_order_sum = $request->min_order_sum;
        $company->save();

        return $company;
    }


    public function changeBlockStatus($block_status, $company_id)
    {
        $company = Company::find($company_id);
        $company->blocked = $block_status;
        $company->save();

        return  $company;
    }

    public function getCompaniesForMainPage()
    {

        return Company::where('blocked', '0')
                ->withCount('products')
                ->with(['products'=>function($query){
                    $query->with(['product'=>function($query){
                        $query->with('category');
                    }]);
                    $query->limit(15);
                }])
                ->take(5)
                ->get();

    }
}
