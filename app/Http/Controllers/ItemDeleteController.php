<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemDeleteController extends Controller
{
    // アイテムを削除するアクション
    public function itemDelete(Request $request)
    {
        // リクエストからitemIdを取得し、整数にキャストします
        $itemId = (int) $request->route("itemId");

        // アイテムモデルから指定されたIDのアイテムを取得し、見つからない場合は例外をスローします
        $item = Item::where("id", $itemId)->firstOrFail();

        // アイテムをデータベースから削除します
        $item->delete();

        // アイテムの削除が成功したら、アイテム一覧ページへリダイレクトし、成功メッセージを表示します
        return redirect()->route("items.index")->with("feedback.success", "注文履歴を削除しました");
    }
}