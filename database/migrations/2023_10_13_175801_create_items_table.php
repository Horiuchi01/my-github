<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        // 'items'テーブルの作成
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // アイテム名
            $table->integer('itemPrice');    // アイテム単価
            $table->integer('totalPrice');   // アイテム合計価格
            $table->timestamps();            // 作成/更新タイムスタンプ
        });
    }

    public function down()
    {
        // 'items'テーブルの削除
        Schema::dropIfExists('items');
    }
}
