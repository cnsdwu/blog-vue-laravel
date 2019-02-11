<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 查头像呢称
     */
    public function base(Request $request){
    	$remember = $request->input('token', 'token');
        $user = \App\User::where('remember_token', $remember);
    	$userTemp = \App\UserTemp::where('remember_token', $remember);
    	if($user->count()){
            return response()
            ->json(['status' => 0, 'message' => '获取头像成功', 'ps' => json_encode($user->select('head','nickname')->first())])
            ->withCallback($request->input('callback'));
        }elseif($userTemp->count()){
    		return response()
            ->json(['status' => 0, 'message' => '获取头像成功', 'ps' => json_encode($userTemp->select('head','nickname')->first())])
            ->withCallback($request->input('callback'));
    	}else{
    		return response()
            ->json(['status' => 3, 'message' => '登录已过期'])
            ->withCallback($request->input('callback'));
    	}
    }
    /**
     * 修改呢称
     */
    public function nickname(Request $request){
        $nickname = $request->input('nickname');
        $token = $request->input('token');
        if(strlen($nickname) < 1 || strlen($nickname) > 100){
            return response()
            ->json(['status' => 1, 'message' => '呢称长度不正确'])
            ->withCallback($request->input('callback'));
        }
        $user = \App\User::where('remember_token', $token);
        if($user->count()){
            if(\App\User::where('nickname', $nickname)->count()){
                return response()
                ->json(['status' => 1, 'message' => '呢称重复'])
                ->withCallback($request->input('callback'));
            }
            $row = $user->update([
                'nickname' => $nickname
            ]);
            if($row){
                return response()
                ->json(['status' => 0, 'message' => '修改成功'])
                ->withCallback($request->input('callback'));
            }
        }else{
            return response()
            ->json(['status' => 1, 'message' => '仅支持注册用户修改'])
            ->withCallback($request->input('callback'));
        }
    }
}
