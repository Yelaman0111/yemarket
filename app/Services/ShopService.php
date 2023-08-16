<?php

namespace App\Services;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use App\Repositories\Interfaces\ShopRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class ShopService
{
    private $shopRepository;

    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

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
        return $this->shopRepository->storeShop($request);
    }

    public function update(Request $request)
    {
        return $this->shopRepository->update($request);
    }

    public function getAllShops()
    {
        return $this->shopRepository->getAllShops();
    }

    public function changeBlockStatus($block_status, $shop_id)
    {
        return $this->shopRepository->changeBlockStatus($block_status, $shop_id);
    }

    public function destroy()
    {
        return $this->shopRepository->destroy();
    }
}
