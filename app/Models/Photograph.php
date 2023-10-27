<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photograph extends Item
{
    // 一括代入を許可するカラムを指定
    protected $fillable = ['name', 'price', 'image', 'subject'];

    // subjectカラムの値を取得するアクセサ
    public function getSubjectAttribute() {
        return $this->attributes['subject'];
    }
}
