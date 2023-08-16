<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\ProductCompany;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function getCompanyOrders($company_id)
    {
        return OrderPivot::where('company_id', $company_id)
            ->with('shop')
            ->with(['orders' => function ($query) {
                $query->with(['productCompany' => function ($query) {
                    $query->with('product');
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    public function getShopOrders($shop_id)
    {
        return OrderPivot::where('shop_id', $shop_id)
            ->with('company')
            ->with(['orders' => function ($query) {
                $query->with(['productCompany' => function ($query) {
                    $query->with('product');
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    public function getOrderById($order_id)
    {
        return OrderPivot::where('id', $order_id)->with('orders')->first();
    }

    public function createOrderPivot($products_id, $user_id)
    {
        $order_pivot = new OrderPivot();
        $order_pivot->shop_id = $user_id;
        $order_pivot->company_id   = ProductCompany::where('id', $products_id[0])->pluck('company_id')->first();
        $order_pivot->status        = 1;
        $order_pivot->save();

        return $order_pivot;
    }

    public function createOrder($order_pivot, $products_count, $company_product_find, $key)
    {
        $order = new Order();
        $order->order_id = $order_pivot->id;
        $order->product_id = $company_product_find[$key]->id;
        $order->count = $products_count[$key];
        $order->price = $company_product_find[$key]->price;
        $order->save();
    }

    public function acceptOrder($company_id, $order_id)
    {
        $order = OrderPivot::where('id', $order_id)
            ->where('company_id', $company_id)
            ->first();

        $order->status = 2;
        $order->save();

        return  $order;
    }

    public function cancelOrder($shop_id, $order_id)
    {
        $order = OrderPivot::where('id', $order_id)
            ->where('shop_id', $shop_id)
            ->first();

        $order->status = 0;
        $order->save();

        return  $order;
    }


    public function confirmDeliveryOrder($shop_id, $order_id)
    {
        $order = OrderPivot::where('id', $order_id)
            ->where('shop_id', $shop_id)
            ->first();

        $order->status = 3;
        $order->save();

        return  $order;
    }

    public function getOrderByIdAndCompanyId($company_id, $order_id)
    {
        return  OrderPivot::where('id', $order_id)
            ->where('company_id', $company_id)
            ->with('company', 'shop')
            ->with(['orders' => function ($query) {
                $query->with(['productCompany' => function ($query) {
                    $query->with('product');
                }]);
            }])
            ->first();
    }
}
