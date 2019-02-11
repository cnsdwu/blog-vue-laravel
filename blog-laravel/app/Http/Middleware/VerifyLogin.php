<?php

namespace App\Http\Middleware;

use Closure;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $username = \App\User::where('username',$request->input('account','account'));
        // $email = \App\User::where('email',$request->input('account','account'));
        $token = \App\User::where('remember_token', $request->input('token','token'));
        $tokenTemp = \App\UserTemp::where('remember_token', $request->input('token','token'));
        if($token->count()){
            return $next($request);
        }elseif ($tokenTemp->count()) {
            return $next($request);
        }else{
            return response()
            ->json(['status' => 1, 'message' => '帐号验证不通过'])
            ->withCallback($request->input('callback'));
        }
        // if($username->count()){
        //     if(\Illuminate\Support\Facades\Hash::check($request->input('password','password'),$username->value('password'))){
        //         return $next($request);
        //     }else{
        //         if($this->usertemp($request->input('usertemp','token'))){
        //             return $next($request);
        //         }
        //         return response()
        //         ->json(['status' => 1, 'message' => '帐号验证不通过!'])
        //         ->withCallback($request->input('callback'));
        //     }
        // }
        // if($email->count()){
        //     if(\Illuminate\Support\Facades\Hash::check($request->input('password','password'),$email->value('password'))){
        //         return $next($request);
        //     }else{
        //         if($this->usertemp($request->input('usertemp','token'))){
        //             return $next($request);
        //         }
        //         return response()
        //         ->json(['status' => 1, 'message' => '帐号验证不通过!'])
        //         ->withCallback($request->input('callback'));
        //     }
        // }
        // if($this->usertemp($request->input('usertemp','token'))){
        //     return $next($request);
        // }
        // return response()
        //     ->json(['status' => 2, 'message' => '帐号验证不通过!'])
        //     ->withCallback($request->input('callback'));
    }
    // private function usertemp($usertemp){
    //     $remember = \App\UserTemp::where('remember_token', $usertemp);
    //     if($remember->count()){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
}
