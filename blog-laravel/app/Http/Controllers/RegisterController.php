<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class RegisterController extends Controller
{
    
    /**
     * 注册
     */
    public function register(Request $request){
        // $request->validate([
        //     'username' => 'required|max:100|unique:users',
        //     'email' => 'required|max:100|unique:users',
        //     'password' => 'required|max:100',
        // ],[
        //     'username.required' => '用户名为空!',
        //     'username.max' => '用户名长度大于100!',
        //     'username.unique' => '用户名已注册!',
        //     'email.required' => '邮箱地址为空!',
        //     'email.max' => '邮箱地址长度大于100!',
        //     'email.unique' => '邮箱地址已注册!',
        //     'password.required' => '密码为空!',
        //     'password.max' => '密码长度大于100!',
        // ]);
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        if(!preg_match('/^[0-9a-zA-Z-_]{1,100}$/',$username)){
            return response()
            ->json(['status' => 1, 'message' => '用户名不合法'])
            ->withCallback($request->input('callback'));
        }
        if(!preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/',$email) || strlen($email) > 100){
            return response()
            ->json(['status' => 1, 'message' => '邮箱不合法'])
            ->withCallback($request->input('callback'));
        }
        if(!preg_match('/^.{6,100}$/',$password)){
            return response()
            ->json(['status' => 1, 'message' => '密码不合法'])
            ->withCallback($request->input('callback'));
        }
        if(\App\User::where('username', $username)->count()){
            return response()
            ->json(['status' => 1, 'message' => '用户名已存在'])
            ->withCallback($request->input('callback'));
        }
        if(\App\User::where('email', $email)->count()){
            return response()
            ->json(['status' => 1, 'message' => '邮箱已被注册'])
            ->withCallback($request->input('callback'));
        }
        // 随机呢称
        $nicknameArr = ['迷人的夜','小城故事','缘昔生','小鹿','东方一刻','话不多'];
        // 随机头像（图片保存在public/images/head）
        $headArr = scandir('images/head');
        $rand = rand(2,count($headArr)-1);
        // 获取用户ip
        $ip = $request->getClientIp();
        $user = new \App\User;
        $user->username = $username;
        $user->email = $email;
        $user->password = \Illuminate\Support\Facades\Hash::make($password);
        $user->nickname = $nicknameArr[rand(0,count($nicknameArr)-1)].time();
        $user->head = env('APP_URL','http://api.wwzc.cc').'/images/head/'.$headArr[$rand];
        $user->ip = $ip;
        if($user->save()){
            // 发送邮件
            \Mail::to($email)
                ->send(new \App\Mail\RegisterMail(
                    encrypt(array('username'=>$username,'email'=>$email))
                ));
            return response()
            ->json(['status' => 0, 'message' => '注册成功','ps' => '请查收邮件并激活帐号'])
            ->withCallback($request->input('callback'));
        }else{
            return response()
            ->json(['status' => 1, 'message' => '注册失败'])
            ->withCallback($request->input('callback'));
        }
        
    }
    /**
     * 激活
     */
    public function active(Request $request){
        try {
            $decrypted = decrypt($request->input('v','default'));
            $user = \App\User::where('username',$decrypted['username'])->where('email', $decrypted['email']);
            if($user->count()){
                if($user->value('active') != 0){
                    if($user->update(['active'=>1]) > 0){
                        return view('active',['message' => '激活成功']);
                    }else{
                        return view('active',['message' => '激活失败']);
                    }
                }else{
                    return view('active',['message' => '请勿重复激活']);
                }
                
            }else{
                return view('active',['message' => '用户不存在']);
            }
        } catch (DecryptException $e) {
            return view('active',['message' => '激活失败']);
            // return response()
            // ->json(['status' => 1, 'message' => '参数错误'])
            // ->withCallback($request->input('callback'));
        }
    }
}