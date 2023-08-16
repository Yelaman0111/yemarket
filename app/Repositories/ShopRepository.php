<?php

namespace App\Repositories;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use App\Repositories\Interfaces\ShopRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopRepository implements ShopRepositoryInterface
{
    public function storeShop(ShopRequest $request)
    {
        $shop = Shop::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return $shop;
    }

    public function update(Request $request)
    {
        $id = auth()->guard('shop-api')->user()->id;

        $shop = Shop::find($id);

        $shop->name = $request->name;
        $shop->password = Hash::make($request->password);
        $shop->phone = $request->phone;
        $shop->address = $request->address;
        $shop->save();

        return $shop;
    }

    public function getAllShops()
    {
        return Shop::withCount('orders')->get();
    }

    public function changeBlockStatus($block_status, $shop_id)
    {
        $shop = Shop::find($shop_id);
        $shop->blocked = $block_status;
        $shop->save();

        return $shop;
    }
    
    public function destroy()
    {
        $shop = Shop::find(auth()->guard('shop-api')->user()->id);
        $shop->delete();
    }
}
