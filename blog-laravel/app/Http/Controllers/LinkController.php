<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Link;

class LinkController extends Controller
{
    /**
     * 获取友链
     */
    public function link(Request $request){
    	$link = new Link;
    	$data = $link->get();
    	$user = new \App\User;
    	foreach ($data as $key => $value) {
    		if(strlen($value->logo) < 1){
    			$data[$key]->logo = $value->user()->value('head');
    		}
    	}
    	return response()
        ->json(['status' => 0, 'message' => '获取成功', 'ps' => json_encode($data)])
        ->withCallback($request->input('callback'));
    }
    /**
     * 添加
     */
    public function add(Request $request){
    	$token = $request->input('token');
    	$name = $request->input('name');
    	$site = $request->input('site');
    	$logo = $request->input('logo');
    	if(strlen($name) < 1 || strlen($name) > 100 || strlen($site) < 1 || strlen($site) > 200){
    		return response()
	        ->json(['status' => 1, 'message' => '参数异常'])
	        ->withCallback($request->input('callback'));
    	}
    	if(!preg_match("/^(http:\/\/|https:\/\/)?[0-9a-zA-z-Z]+(\.[a-zA-Z]+)+$/", $site)){
    		return response()
	        ->json(['status' => 1, 'message' => '网址不合法'])
	        ->withCallback($request->input('callback'));
    	}
    	if(preg_match("/^http/", $site) == 0){
    		$site = 'http://'.$site;
    	}
    	$user = \App\User::where('remember_token', $token);
    	if($user->count() < 1){
	    	return response()
	        ->json(['status' => 1, 'message' => '非注册用户'])
	        ->withCallback($request->input('callback'));
    	}
    	$user_id = $user->value('id');
    	$oldLink = Link::where('user_id', $user_id);
    	if($oldLink->count()){
    		$oldLink->update([
    			'name' => $name,
    			'site' => $site,
    			'logo' => $logo,
    		]);
    		return response()
	        ->json(['status' => 0, 'message' => '添加成功'])
	        ->withCallback($request->input('callback'));
    	}
    	$link = new Link;
    	$link->user_id = $user_id;
    	$link->name = $name;
    	$link->site = $site;
    	$link->logo = $logo;
    	if($link->save()){
    		return response()
	        ->json(['status' => 0, 'message' => '添加成功'])
	        ->withCallback($request->input('callback'));
    	}else{
    		return response()
	        ->json(['status' => 1, 'message' => '添加失败'])
	        ->withCallback($request->input('callback'));
    	}
    }
}
