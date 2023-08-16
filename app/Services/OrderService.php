<?php

namespace App\Services;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\ProductCompany;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ProductCompanyRepositoryInterface;
use PhpOffice\PhpWord\PhpWord;
use Exception;
use Illuminate\Http\Request;

class OrderService
{
    private $orderRepository;
    private $productCompanyRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, ProductCompanyRepositoryInterface $productCompanyRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productCompanyRepository = $productCompanyRepository;
    }

    public function getCompanyOrders()
    {
        $company_id = auth()->guard('company-api')->user()->id;

        return $this->orderRepository->getCompanyOrders($company_id);
    }

    public function getShopOrders()
    {
        $shop_id = auth()->guard('shop-api')->user()->id;

        return $this->orderRepository->getShopOrders($shop_id);
    }

    public function storeOrder(OrderRequest $request)
    {
        $products_id = explode(',', $request->products_id);
        $products_count = explode(',', $request->products_count);
        $user_id = auth()->guard('shop-api')->user()->id;

        $order_pivot = $this->createOrderPivot($products_id, $user_id);
        $this->createOrder($products_id, $order_pivot, $products_count);

        return $this->orderRepository->getOrderById($order_pivot->id);
    }

    public function createOrderPivot($products_id, $user_id)
    {
        return $this->orderRepository->createOrderPivot($products_id, $user_id);
    }

    public function createOrder($products_id, $order_pivot, $products_count)
    {
        $company_product_find = $this->productCompanyRepository->getProuctCompaniesByIds($products_id);

        foreach ($products_id as $key => $product_id) {
            $this->orderRepository->createOrder($order_pivot, $products_count, $company_product_find, $key);
        }
    }

    public function acceptOrder(Request $request)
    {
        $company_id = auth()->guard('company-api')->user()->id;
        $order_id = $request->id;

        return $this->orderRepository->acceptOrder($company_id, $order_id);
    }

    public function cancelOrder($order_id)
    {
        $shop_id = auth()->guard('shop-api')->user()->id;

        return $this->orderRepository->cancelOrder($shop_id, $order_id);
    }

    public function confirmDeliveryOrder($order_id)
    {
        $shop_id = auth()->guard('shop-api')->user()->id;

        return $this->orderRepository->confirmDeliveryOrder($shop_id, $order_id);
    }

    public function downloadOrder($order_id)
    {
        $company_id = auth()->guard('company-api')->user()->id;

        $companyOrder = $this->orderRepository->getOrderByIdAndCompanyId($company_id, $order_id);

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
