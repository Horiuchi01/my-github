<?php

namespace App\Http\Controllers;

use App\Services\ItemService;
use App\Models\Item;

class ItemController extends Controller
{
    protected $itemService;

    // ItemServiceインスタンスを注入
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    // アイテム一覧を表示
    public function index()
    {
        $dbItems = Item::all();
        $items = $this->itemService->getItems();
        return view('items.index', ['items' => $items])->with("dbItems", $dbItems);
    }
}
