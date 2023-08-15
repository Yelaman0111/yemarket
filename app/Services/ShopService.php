<?php

namespace App\Services;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class ShopService
{
    public function shopLogin()
    {
        $credentials = request(['email', 'password']);
        $myTTL = 60 * 24 * 30; //minutes

        JWTAuth::factory()->setTTL($myTTL);
        if (!$token = auth()->guard('shop-api')->attempt($credentials, ['exp' => Carbon::now()->addDays(30)->timestamp])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }

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
        // $shop->email = $request->email;
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
