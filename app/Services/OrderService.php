<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\ProductCompany;
use PhpOffice\PhpWord\PhpWord;
use Exception;

class OrderService
{
    public function getCompanyOrders($company_id)
    {
        $orders = OrderPivot::where('company_id', $company_id)
            ->with('shop')
            ->with(['orders' => function ($query) {
                $query->with(['productCompany' => function ($query) {
                    $query->with('product');
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $orders;
    }

    public function getShopOrders($shop_id)
    {
        $orders = OrderPivot::where('shop_id', $shop_id)
            ->with('company')
            ->with(['orders' => function ($query) {
                $query->with(['productCompany' => function ($query) {
                    $query->with('product');
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $orders;
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

    public function createOrder($products_id, $order_pivot, $products_count)
    {
        $company_product_find = ProductCompany::whereIn('id', $products_id)->with('company')->get();

        foreach ($products_id as $key => $product_id) {
            $order = new Order();
            $order->order_id = $order_pivot->id;
            $order->product_id = $company_product_find[$key]->id;
            $order->count = $products_count[$key];
            $order->price = $company_product_find[$key]->price;
            $order->save();
        }
    }

    public function acceptOrder($order_id, $company_id)
    {
        $order = OrderPivot::where('id', $order_id)
            ->where('company_id', $company_id)
            ->first();

        $order->status = 2;
        $order->save();

        return  $order;
    }

    public function cancelOrder($order_id, $shop_id)
    {
        $order = OrderPivot::where('id', $order_id)
            ->where('shop_id', $shop_id)
            ->first();

        $order->status = 0;
        $order->save();

        return  $order;
    }

    public function confirmDeliveryOrder($order_id, $shop_id)
    {
        $order = OrderPivot::where('id', $order_id)
            ->where('shop_id', $shop_id)
            ->first();

        $order->status = 3;
        $order->save();

        return  $order;
    }

    public function downloadOrder($order_id, $company_id)
    {

        $companyOrder = OrderPivot::where('id', $order_id)
            ->where('company_id', $company_id)
            ->with('company', 'shop')
            ->with(['orders' => function ($query) {
                $query->with(['productCompany' => function ($query) {
                    $query->with('product');
                }]);
            }])
            ->first();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $boldFontStyle = array('bold' => true);

        $title = "Расходная накладная";
        $section->addText($title, $boldFontStyle, array('align' => 'center'));
        $section->addTextBreak();

        $section->addText('Поставщик:', null, array('align' => 'left'));
        $section->addText(htmlspecialchars($companyOrder->company->name), $boldFontStyle, array('align' => 'left'));
        $section->addText(htmlspecialchars($companyOrder->company->phone), null, array('align' => 'left'));

        $section->addTextBreak();
        $section->addTextBreak();

        $section_style = $section->getStyle();
        $position =
            $section_style->getPageSizeW()
            - $section_style->getMarginRight()
            - $section_style->getMarginLeft();

        $phpWord->addParagraphStyle("leftRight", array("tabs" => array(
            new \PhpOffice\PhpWord\Style\Tab("right", $position)
        )));

        $section->addText("Покупатель:\t Дата доставки:" . date("Y.m.d"),  $boldFontStyle, "leftRight");
        $section->addText(htmlspecialchars($companyOrder->shop->name . "\t Дата заказа:" . date_format($companyOrder->created_at, "Y.m.d")), array(), "leftRight");
        $section->addText(htmlspecialchars($companyOrder->shop->address), null, array('align' => 'left'));
        $section->addText(htmlspecialchars($companyOrder->shop->phone), null, array('align' => 'left'));
        $section->addTextBreak();

        //////////////////////////////
        //Таблица товаров
        $table = array('borderColor' => 'black', 'borderSize' => 1, 'cellMargin' => 50, 'valign' => 'center');
        $phpWord->addTableStyle('table', $table);
        $table = $section->addTable('table');
        $table->addRow();
        $table->addCell(800)->addText(htmlspecialchars("№ п/п"));
        $table->addCell(4800)->addText(htmlspecialchars("Наименование товара"));
        $table->addCell(1300)->addText(htmlspecialchars("Цена (тг)"));
        $table->addCell(1000)->addText(htmlspecialchars("Кол-во"));
        $table->addCell(1300)->addText(htmlspecialchars("Сумма (тг)"));

        $total_price = 0;
        foreach ($companyOrder->orders as $key => $order) {
            $table->addRow();
            $table->addCell(800)->addText(htmlspecialchars($key + 1));
            $table->addCell(4800)->addText($order->productCompany->product->name);
            $table->addCell(1300)->addText(htmlspecialchars($order->price));
            $table->addCell(1000)->addText(htmlspecialchars($order->count));
            $table->addCell(1300)->addText(htmlspecialchars($order->price * $order->count));

            $total_price += $order->price * $order->count;
        }
        $table->addRow();
        $table->addCell(6900)->addText(htmlspecialchars(""));
        $table->addCell(1000)->addText(htmlspecialchars("Итого"));
        $table->addCell(1300)->addText(htmlspecialchars($total_price));
        //Таблица товаров конец

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addText(htmlspecialchars("Принял, претензий к внешнему виду товара"), null, array('align' => 'right'));
        $section->addText(htmlspecialchars("и комплектности не имею."), null, array('align' => 'right'));
        $section->addText("Сдал___________________________\t ______________________________________",  array(), "leftRight");

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('orders/Заказ №' . $order_id . '.docx'));
        } catch (Exception $e) {
            return $e;
        }
        return response()->download(storage_path('orders/Заказ №' . $order_id . '.docx'));
    }
}
