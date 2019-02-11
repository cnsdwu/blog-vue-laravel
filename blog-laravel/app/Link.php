<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * 关联用户：反向一对多
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
