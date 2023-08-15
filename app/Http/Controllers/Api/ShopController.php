<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\ShopRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ShopResource;
use App\Services\OrderService;
use App\Services\ShopService;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function store(ShopRequest $request, ShopService $service)
    {
        return new ShopResource($service->storeShop($request));
    }

    public function shopLogin(ShopService $service)
    {
        return $service->shopLogin();
    }

    public function show()
    {
        return new ShopResource(auth()->guard('shop-api')->user());
    }

    public function update(Request $request, ShopService $service)
    {
        return new ShopResource($service->update($request));
    }

    public function destroy(ShopService $service)
    {
        $service->destroy();
        return response()->noContent();
    }

    public function storeOrder(OrderRequest $request, OrderService $service)
    {
        return new OrderResource($service->storeOrder($request));
    }

    public function getOrders(OrderService $service)
    {
        return OrderResource::collection($service->getShopOrders());
    }

    public function cancelOrder($id, OrderService $service)
    {
        return new OrderResource($service->cancelOrder($id));
    }

    public function confirmDeliveryOrder($id, OrderService $service)
    {
        return new OrderResource($service->confirmDeliveryOrder($id));
    }
}
