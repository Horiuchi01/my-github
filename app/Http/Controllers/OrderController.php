<?php

namespace App\Http\Controllers;

use App\Services\ItemService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $itemService;

    // ItemServiceを依存注入
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    // オーダー確認ロジック
    public function confirm(Request $request)
    {
        $items = $this->itemService->getItems();
        $orderCounts = [];
        $totalPayment = 0;

        foreach ($items as $item) {
            $itemName = $item->getNameAttribute();
            $count = $request->input('quantity.' . $itemName, 0);
            
            // 数量が負の場合、0にリセット
            if ($count < 0) {
                $count = 0;
            }

            $item->setItemCountAttribute($count);
            $orderCounts[$itemName] = $count;
            $totalPayment += $item->getTotalPrice();
        }

        // ビューにデータを渡してレンダリング
        return view('order.confirm', [
            'items' => $items,
            'orderCounts' => $orderCounts,
            'totalPayment' => $totalPayment,
        ]);
    }
}