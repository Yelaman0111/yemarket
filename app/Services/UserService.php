<?php

namespace App\Services;

use App\Http\Requests\Admin\AdminOptoshopProductUpdate;
use App\Http\Requests\Admin\AdminOptoshopUpdate;
use App\Http\Requests\Admin\AdminProductUpdate;
use App\Http\Requests\UserRequest;
use App\Models\Admin;
use App\Models\OptoShop;
use App\Models\Product;
use App\Models\ProductCompany;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService{

    public function storeUser(UserRequest $request): User
    {
        $admin = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return $admin;
    }

    // public function products()
    // {

    //     return Product::with('category:id,title,parent_id')
    //     ->with('brand:id,name')
    //     ->with(['companiesProduct'=>function($query){
    //         $query->with('company');
    //     }])
    //     ->paginate();
    // }
    
    // public function updateProduct(AdminProductUpdate $request, $id): Product
    // {

    //     $product = Product::find($id);
    //     $product->archived = $request->archived;
    //     $product->approved = $request->approved;
    //     $product->save();

    //     return $product;
    // }

    // public function updateOptoShop(AdminOptoshopUpdate $request, $id): OptoShop
    // {
    //     $optoshop = OptoShop::find($id);
    //     $optoshop->blocked = $request->blocked;
    //     $optoshop->approved = $request->approved;
    //     $optoshop->save();

    //     return  $optoshop;
    // }

    // public function updateOptoShopProduct(AdminOptoshopProductUpdate $request, $id): ProductCompany
    // {

    //     $productCompany = ProductCompany::find($id);
    //     $productCompany->archived = $request->archived;
    //     $productCompany->approved = $request->approved;
    //     $productCompany->save();

    //     return $productCompany;
    // }

}