<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 关联文本：一对一
     */
    public function articleText(){
    	return $this->hasOne('App\ArticleText');
    }
    /**
     * 关联评论：一对多
     */
    public function comment(){
    	return $this->hasMany('App\Comment');
    }
    /**
     * 关联用户：反向一对多
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * 关联临时用户：反向一对多
     */
    public function userTemp(){
    	return $this->belongsTo('App\UserTemp');
    }
    /**
     * 关联图片：一对多
     */
    public function articleImage(){
    	return $this->hasMany('App\ArticleImage');
    }
}
