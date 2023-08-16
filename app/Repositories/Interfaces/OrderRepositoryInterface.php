<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\OrderRequest;

interface OrderRepositoryInterface
{
    public function getCompanyOrders($company_id);

    public function getShopOrders($shop_id);

    public function getOrderById($order_id);

    public function createOrderPivot($products_id, $user_id);

    public function createOrder($order_pivot, $products_count, $company_product_find, $key);

    public function acceptOrder($company_id, $order_id);

    public function cancelOrder($shop_id, $order_id);

    public function confirmDeliveryOrder($shop_id , $order_id);
    
    public function getOrderByIdAndCompanyId($company_id, $order_id);


}