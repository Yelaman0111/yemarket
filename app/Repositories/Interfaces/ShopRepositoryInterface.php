<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\ShopRequest;
use Illuminate\Http\Request;

interface ShopRepositoryInterface
{
    public function storeShop(ShopRequest $request);

    public function update(Request $request);

    public function getAllShops();

    public function changeBlockStatus($block_status, $shop_id);

    public function destroy();

}