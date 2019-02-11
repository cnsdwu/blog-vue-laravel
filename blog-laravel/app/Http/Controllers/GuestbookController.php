<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Guestbook;

class GuestbookController extends Controller
{
    /**
     * 添加
     */
    public function add(Request $request){
    	$token = $request->input('token');
    	$content = $request->input('content');
    	if(strlen($content) < 1){
    		return response()
	        ->json(['status' => 1, 'message' => '参数异常'])
	        ->withCallback($request->input('callback'));
    	}
    	$user = \App\User::where('remember_token', $token);
    	$userTemp = \App\UserTemp::where('remember_token', $token);
    	$user_id = 0;
    	$user_temp_id = 0;
    	if($user->count()){
    		$user_id = $user->value('id');
    	}else if($userTemp->count()){
    		$user_temp_id = $userTemp->value('id');
    	}else{
    		return response()
	        ->json(['status' => 1, 'message' => '未登录'])
	        ->withCallback($request->input('callback'));
    	}

    	$guestBook = new Guestbook;
    	$guestBook->user_id = $user_id;
    	$guestBook->user_temp_id = $user_temp_id;
    	$guestBook->content = $content;
    	if($guestBook->save()){
    		return response()
	        ->json(['status' => 0, 'message' => '添加成功'])
	        ->withCallback($request->input('callback'));
    	}else{
    		return response()
	        ->json(['status' => 1, 'message' => '添加失败'])
	        ->withCallback($request->input('callback'));
    	}
    }
    /**
     * 列表
     */
    public function list(Request $request){
    	$guestBook = new Guestbook;
    	$data = $guestBook->orderBy('id', 'desc')->get();
    	foreach ($data as $key => $value) {
    		if($data[$key]->user_id){
    			$suffix = '';
    			$user = \App\User::where('id', $data[$key]->user_id);
    		}else{
    			$suffix = '*';
    			$user = \App\UserTemp::where('id', $data[$key]->user_temp_id);
    		}
    		$data[$key]->nickname = $user->value('nickname').$suffix;
    		$data[$key]->head = $user->value('head');
    		$data[$key]->time = $this->getTime($data[$key]->created_at);
    		unset($data[$key]->user_id);
    		unset($data[$key]->user_temp_id);
    		unset($data[$key]->created_at);
    		unset($data[$key]->updated_at);
    	}
    	return response()
	        ->json(['status' => 0, 'message' => '获取成功', 'ps' => json_encode($data)])
	        ->withCallback($request->input('callback'));
    }
    /**
     * 时间转换
     */
    private function getTime($date){
        $time = date_timestamp_get(date_create($date));
        $value = time() - $time;
        if(($value/(3600*24*365)) >= 1){
            return floor($value/(3600*24*365)).'年前';
        }elseif (($value/(3600*24*30)) >= 1) {
            return floor($value/(3600*24*30)).'月前';
        }elseif (($value/(3600*24)) >= 1) {
            return floor($value/(3600*24)).'天前';
        }elseif (($value/(3600)) >= 1) {
            return floor($value/(3600)).'小时前';
        }elseif (($value/(60)) >= 1) {
            return floor($value/(60)).'分钟前';
        }elseif ($value >= 1) {
            return floor($value).'秒前';
        }elseif ($value < 1) {
            return '刚刚';
        }else{
            return ' ';
        }
    }
}
