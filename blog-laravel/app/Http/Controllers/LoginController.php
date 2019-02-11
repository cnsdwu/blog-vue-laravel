<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	/**
     * 临时号
     */
    public function temp(Request $request){
        if(strlen($request->input('nickname')) < 1 || strlen($request->input('nickname')) > 100){
            return response()
            ->json(['status' => 1, 'message' => '呢称长度不合法'])
            ->withCallback($request->input('callback'));
        }
        if (!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/",$request->input('email'))) {
            return response()
            ->json(['status' => 1, 'message' => '邮箱格式不合法'])
            ->withCallback($request->input('callback'));
        }
        if($request->input('site')){
            if (!preg_match("/^(http://|https://)?[0-9a-zA-z-Z]+(\.[a-zA-Z]+)+$/",$request->input('site'))) {
                return response()
                ->json(['status' => 1, 'message' => '网址不合法'])
                ->withCallback($request->input('callback'));
            }
        }
        
    	$remember = md5($request->input('email').env('APP_KEY','cnsdwu').$request->input('password').time());
        $headArr = scandir('images/head');
        $rand = rand(2,count($headArr)-1);
        $ip = $request->getClientIp();
        $user = new \App\UserTemp;
        $user->email = $request->input('email');
        $user->nickname = $request->input('nickname');
        $user->site = $request->input('site', '');
        $user->head = env('APP_URL','http://api.wwzc.cc').'/images/head/'.$headArr[$rand];
        $user->ip = $ip;
        $user->remember_token = $remember;
        if($user->save()){
            return response()
            ->json(['status' => 0, 'message' => '登录成功','ps' => $remember])
            ->withCallback($request->input('callback'));
        }else{
            return response()
            ->json(['status' => 1, 'message' => '登录失败'])
            ->withCallback($request->input('callback'));
        }
        
    }
    /**
     * 用户登录
     */
    public function login(Request $request){
    	// $request->validate([
     //        'account' => 'required|max:100',
     //        'password' => 'required|max:100',
     //    ],[
     //        'account.required' => '用户名为空!',
     //        'account.max' => '用户名长度大于100!',
     //        'password.required' => '密码为空!',
     //        'password.max' => '密码长度大于100!',
     //    ]);
        $account = $request->input('account');
        if (!preg_match("/^[0-9a-zA-Z-_@.]{1,100}$/",$account)) {
            return response()
            ->json(['status' => 1, 'message' => '用户不存在'])
            ->withCallback($request->input('callback'));
        }
        $username = \App\User::where('username',$account);
        $email = \App\User::where('email',$account);
        $vcode = $this->getCode();
        // dd($vcode);
        if($username->count()){
            // 判断验证码
            $dbVcode = $username->value('vcode');
            $username->update(['vcode' => $vcode[0]]);
            if($username->value('attempt') > 5){
                if(strlen($request->input('vcode')) > 0){
                    if($dbVcode != $request->input('vcode')){
                        return response()
                        ->json(['status' => 4, 'message' => '验证码错误', 'ps' => json_encode($vcode[1])])
                        ->withCallback($request->input('callback'));
                    }
                }else{
                    return response()
                    ->json(['status' => 4, 'message' => '请输入验证码', 'ps' => json_encode($vcode[1])])
                    ->withCallback($request->input('callback'));
                }
            }
            // 验证密码
        	if(\Illuminate\Support\Facades\Hash::check($request->input('password','password'),$username->value('password'))){
        		$remember = md5($account.env('APP_KEY','cnsdwu').$request->input('password').time());
        		$username -> update(['remember_token' => $remember, 'attempt' => 0]);
	        	return response()
	            ->json(['status' => 0, 'message' => '登录成功','ps' => $remember])
	            ->withCallback($request->input('callback'));
	        }else{
                $username->increment('attempt');
            }
        }
        if($email->count()){
            $dbVcode = $email->value('vcode');
            $email->update(['vcode' => $vcode[0]]);
            if($email->value('attempt') > 5){
                if(strlen($dbVcode) > 0){
                    if($email->value('vcode') != $request->input('vcode')){
                        return response()
                        ->json(['status' => 1, 'message' => '验证码错误', 'ps' => json_encode($vcode[1])])
                        ->withCallback($request->input('callback'));
                    }
                }else{
                    return response()
                    ->json(['status' => 1, 'message' => '请输入验证码', 'ps' => json_encode($vcode[1])])
                    ->withCallback($request->input('callback'));
                }
            }
			if(\Illuminate\Support\Facades\Hash::check($request->input('password','password'),$email->value('password'))){
				$remember = md5($account.env('APP_KEY','cnsdwu').$request->input('password').time());
				$email -> update(['remember_token' => $remember, 'attempt' => 0]);
				return response()
	            ->json(['status' => 0, 'message' => '登录成功','ps' => $remember])
	            ->withCallback($request->input('callback'));
	        }else{
                $email->increment('attempt');
            }
        }
    	return response()
            ->json(['status' => 1, 'message' => '登录失败', 'ps' => json_encode($vcode[1])])
            ->withCallback($request->input('callback'));
        
    }
    private function getCode(){
        $codeArr = array(
            '左顾右盼', '东张西望', '望眼欲穿', '望洋兴叹', '刮目相看', 
            '走马观花', '虎视眈眈', '目不斜视', '目不忍视', '察颜观色', 
            '冷眼旁观', '束手旁观', '坐井观天', '兴高采烈', '喜出望外', '喜形于色', '喜上眉梢', 
            '喜不自胜', '喜不自禁', '喜气洋洋', '喜笑颜开', '笑逐颜开', '心旷神怡', 
            '心满意足', '纸醉金迷', '心花怒放', '其乐融融', 
            '乐不可支', '欣喜若狂', '一视同仁', '一清二白', '大义灭亲', '大公无私', '义无反顾', 
            '正气凛然', '刚正不阿', '冰清玉洁', '克己奉公', '严于律己', 
            '两袖清风', '忍辱负重', '奉公守法', '表里如一', '斩钉截铁', '忠心耿耿', '忠贞不渝', 
            '高风亮节', '虚怀若谷', '深明大义', '童叟无欺', 
            '廉洁奉公', '毅然决然', '鞠躬尽瘁', '死而后已', 
            '舍己为人', '舍生忘死', '舍生取义', '秋色宜人', '天朗气清', '一叶知秋', '春种秋收', 
            '春花秋月', '秋风萧瑟', '秋雨绵绵', 
            '秋意深浓', '重峦叠嶂', '崇山峻岭', '悬崖峭壁', '连绵起伏', 
            '滔滔不绝', '一泻千里', '波澜壮阔', '惊涛骇浪', 
            '湖光山色', '山清水秀', '山明水秀', '青山绿水', '山水一色', 
            '百花齐放', '百花争艳', '遍地开花', '笔下生花', '闭月羞花', '风花雪月', '花容月貌', 
            '草木皆兵'
        );
        $oneCode = $codeArr[rand(0, count($codeArr)-1)];
        $data = preg_split('/(?<!^)(?!$)/u', $oneCode );
        shuffle($data);
        return array($oneCode, $data);
    }
}
