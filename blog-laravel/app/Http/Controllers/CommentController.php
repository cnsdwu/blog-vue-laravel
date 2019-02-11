<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Comment;

class CommentController extends Controller
{
    /**
     * 增
     */
    public function add(Request $request){
    	$content = $request->input('content');
    	$articleId = $request->input('id');
        // $remembertemp = $request->input('usertemp');
        $token = $request->input('token');
        // $account = $request->input('account');
        $user = \App\User::where('remember_token', $token);
        $userTemp = \App\UserTemp::where('remember_token', $token);
        $user_id = 0;
        $user_temp_id = 0;
        if($user->count()){
            // $user = \App\User::where('remember_token', $remember);
            $user_id = $user->value('id');
        }else if($userTemp->count()){
            // $user = \App\User::where('username',$account);
            $user_temp_id = $userTemp->value('id');
        }else{
            return response()
            ->json(['status' => 1, 'message' => '登录已过期'])
            ->withCallback($request->input('callback'));
        }
        // $user = null;
        // $usertemp = null;
        // if($remember){
        //     $user = \App\User::where('remember_token', $remember);
        // }else if($account){
        //     $user = \App\User::where('username',$account);
        // }else if($remembertemp){
        //     $usertemp = \App\UserTemp::where('remember_token', $remembertemp);
        // }else{
        //     return response()
        //     ->json(['status' => 1, 'message' => '未检测到登录!'])
        //     ->withCallback($request->input('callback'));
        // }
        // $user_id = 0;
        // $user_temp_id = 0;
        // if($user != null){
        //     if(!$user->count()){
        //         return response()
        //         ->json(['status' => 1, 'message' => '未检测到登录!'])
        //         ->withCallback($request->input('callback'));
        //     }
        //     $user_id = $user->value('id');
        // }elseif($usertemp != null){
        //     if(!$usertemp->count()){
        //         return response()
        //         ->json(['status' => 1, 'message' => '未检测到登录!'])
        //         ->withCallback($request->input('callback'));
        //     }
        //     $user_temp_id = $usertemp->value('id');
        // }else{
        //     return response()
        //     ->json(['status' => 1, 'message' => '未检测到登录!'])
        //     ->withCallback($request->input('callback'));
        // }
    	if($content == '' || $articleId == ''){
    		return response()
            ->json(['status' => 1, 'message' => '参数缺失'])
            ->withCallback($request->input('callback'));
    	}
        if(\App\Article::where('id', $articleId)->count() < 1){
            return response()
            ->json(['status' => 3, 'message' => '参数异常'])
            ->withCallback($request->input('callback'));
        }
    	$comment = new Comment;
        $comment->user_id = (int)$user_id;
    	$comment->user_temp_id = (int)$user_temp_id;
    	$comment->article_id = (int)$articleId;
    	$comment->content = $content;
    	if($comment->save()){
            return response()
            ->json(['status' => 0, 'message' => '提交成功'])
            ->withCallback($request->input('callback'));
        }else{
            return response()
            ->json(['status' => 1, 'message' => '提交失败'])
            ->withCallback($request->input('callback'));
        }
    	
    }
    /**
     * 列表
     */
    public function list(Request $request){
    	$comment = new Comment;
    	$commentData = $comment->where('article_id',(int)$request->input('id'))->get();
        if($commentData->count()){
            $data = [];
            foreach($commentData as $key => $value){
                $data[$key]['content'] = $value->content;
                if($value->user_id){
                    $suffix = '';
                    $user = $value->user();
                }else{
                    $suffix = '*';
                    $user = $value->userTemp();
                }
                $data[$key]['author'] = $user->value('nickname').$suffix;
                $data[$key]['article_id'] = $value->article_id;
                $data[$key]['time'] = $this->getTime($value->created_at);
                $data[$key]['head'] = $user->value('head');

            }
            // dd($data);
            return response()
            ->json(['status' => 0, 'message' => '获取成功', 'ps' => json_encode($data)])
            ->withCallback($request->input('callback'));
        }else{
            return response()
            ->json(['status' => 1, 'message' => '暂无数据'])
            ->withCallback($request->input('callback'));
        }
    	
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
