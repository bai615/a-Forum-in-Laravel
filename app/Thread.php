<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded = []; // 意味所有属性均可更新，后期会修复此安全隐患
}
