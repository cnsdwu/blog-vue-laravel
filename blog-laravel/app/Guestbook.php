<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    /**
     * 关联用户：反向一对多
     */
    public function user(){
    	return $this->belongsTo('\App\User');
    }
    /**
     * 关联临时用户：反向一对多
     */
    public function userTemp(){
    	return $this->belongsTo('\App\UserTemp');
    }
}
