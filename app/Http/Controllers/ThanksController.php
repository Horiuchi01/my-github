<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ThanksController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション
        $data = $request->validate([
            'item-names.*' => 'required|string',
            'item-prices.*' => 'required|integer',
            'total-price' => 'required|integer',
        ]);

        // バリデーション後のデータを変数に格納
        $itemNames = $data['item-names'];
        $itemPrices = $data['item-prices'];
        $totalPrice = $data['total-price'];

        // アイテムデータをDBに保存
        foreach (array_combine($itemNames, $itemPrices) as $itemName => $itemPrice) {
            Item::create([
                'name' => $itemName,
                'itemPrice' => $itemPrice,
                'totalPrice' => $totalPrice,
            ]);
        }
        
        // ビューをレンダリング
        return view('thanks.thanks', compact('itemNames', 'itemPrices', 'totalPrice'));
    }
}