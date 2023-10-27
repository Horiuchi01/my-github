<?php

namespace App\Models;

class Illustration extends Item
{
    protected $fillable = ['name', 'price', 'image', 'type'];

    // アクセサ: type カラムの値を取得
    public function getTypeAttribute() {
        return $this->attributes['type'];
    }

    // ミューテタ: type カラムに値を設定
    public function setTypeAttribute($value) {
        $this->attributes['type'] = $value;
    }
}
