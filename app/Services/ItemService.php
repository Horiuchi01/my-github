<?php

namespace App\Services;

use App\Models\Illustration;
use App\Models\Photograph;

class ItemService
{
    // 異なるタイプのアイテムオブジェクトを配列で返す。
    public function getItems()
    {
        return [
            new Illustration(['name' => 'A', 'price' => 500, 'image' => '00004-910266984.png', 'type' => 'AIイラスト']),
            new Illustration(['name' => 'B', 'price' => 700, 'image' => '21_wx7wn5xy0l.jpg', 'type' => 'イラスト']),
            new Photograph(['name' => 'C', 'price' => 900, 'image' => 'IMG20230716172629.jpg', 'subject' => 'フィギュア']),
            // 他のアイテムもここに追加可能
        ];
    }
}
