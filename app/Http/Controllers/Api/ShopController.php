<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ShopResource;
use App\Models\OrderPivot;
use App\Models\Shop;
use App\Services\OrderService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class ShopController extends Controller
{

    public function store(ShopRequest $request, ShopService $service)
    {
        $shop = $service->storeShop($request);

        return new ShopResource($shop);
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

    public function show()
    {
        return new ShopResource(auth()->guard('shop-api')->user());
    }

    public function update(Request $request, ShopService $service)
    {
        $id = auth()->guard('shop-api')->user()->id;
        return new ShopResource($service->update($request, $id));
    }

    public function destroy()
    {
        $shop = Shop::find(auth()->guard('shop-api')->user()->id);
        $shop->delete();
        return response()->noContent();
    }


    public function storeOrder(OrderRequest $request, OrderService $service)
    {
        $products_id = explode(',', $request->products_id);
        $products_count = explode(',', $request->products_count);
        $user_id = auth()->guard('shop-api')->user()->id;

        $order_pivot = $service->createOrderPivot($products_id, $user_id);
        $service->createOrder($products_id, $order_pivot, $products_count);

        return new OrderResource(OrderPivot::where('id', $order_pivot->id)->with('orders')->first());
    }

    public function getOrders(OrderService $service)
    {
        $shop_id = auth()->guard('shop-api')->user()->id;
        return OrderResource::collection($service->getShopOrders($shop_id));
    }

    // public function getOrder()
    // {
    //     $shop_id = auth()->guard('shop-api')->user();
    //     return OrderResource::collection($service->getShopOrders($shop_id));
    // }

    public function cancelOrder($id, OrderService $service)
    {
        $shop_id = auth()->guard('shop-api')->user()->id;
        return new OrderResource($service->cancelOrder($id, $shop_id));
    }

    public function confirmDeliveryOrder($id, OrderService $service)
    {
        $shop_id = auth()->guard('shop-api')->user()->id;
        return new OrderResource($service->confirmDeliveryOrder($id, $shop_id));
    }
}
