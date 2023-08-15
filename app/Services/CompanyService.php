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
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class CompanyService
{
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


    public function changeBlockStatus(Request $request, $company_id, ProductCompanyService $productService)
    {
        $productService->blockProductsCompany($request->block_status, $company_id);

        $company = Company::find($company_id);
        $company->blocked = $request->block_status;
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

    public function getShoppingCart(Request $request)
    {
        return Company::whereHas('products', function ($query) use ($request) {
            $query->whereIn('id', explode(',', $request->products_id));
        })->with(['products' => function ($query) use ($request) {
            $query->whereIn('id', explode(',', $request->products_id));
            $query->with('product');
        }])
            ->get();
    }

    public function getAllCompanies()
    {
        return Company::withCount('products')->withCount('orders')->paginate();
    }
}
