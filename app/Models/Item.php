<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected static $count = 0;

    protected $fillable = ['name', 'price', 'itemPrice', 'totalPrice', 'image', 'itemCount'];
    
    protected static function booted() {
        static::created(function ($item) {
            self::$count++;
        });
    }

    // アイテム作成カウントを取得
    public static function getCount() {
        return self::$count;
    }

    // アイテムの総価格を取得
    public function getTotalPrice() {
        return $this->price * $this->itemCount;
    }

    // 以下、アクセサメソッド
    public function getNameAttribute() {
        return $this->attributes['name'];
    }

    public function getPriceAttribute() {
        return $this->attributes['price'];
    }

    public function getImageAttribute() {
        return $this->attributes['image'];
    }

    public function getItemCountAttribute() {
        return $this->attributes['itemCount'];
    }

    // アイテムの個数を設定
    public function setItemCountAttribute($count) {
        $this->attributes['itemCount'] = $count;
    }
}
