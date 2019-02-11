<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Article;

class ArticleController extends Controller
{
    /**
     * 增
     */
    public function add(Request $request){
    	// $request->validate([
     //        'type' => 'required|numeric',
     //        'title' => 'required|max:250',
     //        'content' => 'required',
     //    ],[
     //        'type.required' => '参数为空!',
     //        'type.numeric' => '参数错误!',
     //        'title.required' => '标题为空!',
     //        'title.max' => '标题长度大于250!',
     //        'content.required' => '正文为空!',
     //    ]);
        // return (array)$request->images;
        $type = $request->input('type', 1);
        $title = $request->input('title');
        $content = $request->input('content');
        $token = $request->input('token', 'token');
        // $remember = $request->input('token');
        // $account = $request->input('account');
        $user = \App\User::where('remember_token', $token);
        $userTemp = \App\UserTemp::where('remember_token', $token);
        $user_id = null;
        $user_temp_id = null;
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
        if($title == '' || $content == ''){
            return response()
            ->json(['status' => 1, 'message' => '参数缺失'])
            ->withCallback($request->input('callback'));
        }
        if(strlen($title) > 250){
            return response()
            ->json(['status' => 1, 'message' => '标题长度大于250个字符'])
            ->withCallback($request->input('callback'));
        }
        // dd($user->get());
    	switch ((int)$type) {
    		case 1:
                // $this->addText(htmlentities($title), htmlentities($content), $request->images, $request->descs);
    			$article_id = $this->addText($title, $content, (array)$request->input('images'), (array)$request->input('descs'), $request->input('cover'), $user_id, $user_temp_id);
    			break;
    		case '2':
    			# code...
    			break;
    		default:
    			# code...
    			break;
    	}
        if($article_id){
            return response()
            ->json(['status' => 0, 'message' => '提交成功', 'ps' => $article_id])
            ->withCallback($request->input('callback'));
        }else{
            return response()
            ->json(['status' => 1, 'message' => '提交失败'])
            ->withCallback($request->input('callback'));
        }
    	
    }
    /**
     * 删
     */
    public function delete(Request $request){
    	Article::destroy($request->input('id'));
    }
    /**
     * 改
     */
    public function update(Request $request){
    	// $article = Article::where('id',$request->input('id'));
    	$article = Article::find($request->input('id'));
    	$article->title = $request->input('title');
    	$article->content = $request->input('content');
    	$article->save();
    }
    /**
     * 查
     */
    public function check(Request $request){
        if($request->input('id') == ''){
            return response()
            ->json(['status' => 1, 'message' => '参数缺失'])
            ->withCallback($request->input('callback'));
        }
    	$article = Article::find([(int)$request->input('id')]);
        // dd($article);
    	if($article->count()){
			$articleData = $article->first();
            if($articleData['type'] == 1){
                $articleTextData = $articleData->articleText()->first();
            }
            // $articleData->content = html_entity_decode($articleData->content);
            // $articleData->content = $articleData->content;
            // preg_match_all('/<img [a-zA-Z0-9-" =]+src=\"(http:\/\/[a-zA-Z0-9]+\.[a-zA-Z]+\/[a-zA-Z0-9-_\/]+\.[a-zA-Z]+)\">/i',$articleData->content,$matchArr);
            // return $matchArr;
            $articleData->images = $articleData->articleImage()->get();
            $articleData->cover = $this->isEmpty(@$articleTextData->cover);
            // $articleData->desc = $articleTextData->cover;
            $articleData->admire = $this->isEmpty(@$articleTextData->admire, 0);
            $articleData->commentNum = $articleData->comment()->count();
            $articleData->time = $this->getTime($articleData->created_at);
            if($articleData->user_id){
                $suffix = '';
                $user = $articleData->user();
            }else{
                $suffix = '*';
                $user = $articleData->userTemp();
            }
            $articleData->author = $user->value('nickname').$suffix;
            $articleData->head = $user->value('head');
            // dd(json_encode($articleData));
	    	return response()
	        ->json(['status' => 0, 'message' => '获取成功','ps' => json_encode($articleData)])
	        ->withCallback($request->input('callback'));
    	}else{
			return response()
	        ->json(['status' => 1, 'message' => '内容不存在'])
	        ->withCallback($request->input('callback'));
    	}
    }
    /**
     * 列表
     */
    public function list(Request $request){
    	$article = new Article;
    	$articleData = $article->where('display', 1)
            ->orderBy('id', 'desc')
            ->skip((int)$request->input('skip',0))
            ->take((int)$request->input('take',20))
            ->leftJoin('article_images', 'articles.id', '=', 'article_images.article_id')
            ->leftJoin('article_texts', 'articles.id', '=', 'article_texts.article_id')
            ->select('articles.id', 'articles.user_id', 'articles.title', 'articles.content', 'articles.created_at', 'article_images.article_id', 'article_images.desc', 'article_images.path', 'article_texts.admire', 'article_texts.cover')
            ->get();
        // $data = $article->crossJoin('article_images')->get();
        if(count($articleData)){
            $arrData = [];
            foreach($articleData as $key => $value){
                $content = strip_tags(html_entity_decode($value->content));
                $arrData[$key]['id'] = $value->id;
                //用户id
                $arrData[$key]['user_id'] = $value->user_id;
                $arrData[$key]['user_temp_id'] = $value->user_temp_id;
                // 标题
                $arrData[$key]['title'] = $value->title;
                // 时间
                $arrData[$key]['time'] = $this->getTime($value->created_at);
                $arrData[$key]['admire'] = $value->admire;
                $arrData[$key]['commentNum'] = $value->comment()->count();
                $arrData[$key]['cover'] = $value->cover;
                // 内容
                if(strlen($content) > 128){
                    $arrData[$key]['content'] = mb_substr($content,0, 128).'...';
                }else{
                    $arrData[$key]['content'] = $content;
                }
                // $arrData[$value->id]['created_at'] = $value->created_at;
                $arrData[$key]['article_id'] = $value->article_id;
                //将多个图片描述并成数组
                if(empty($arrData[$key]['desc'])){
                    $arrData[$key]['desc'] = [$value->desc];
                }else{
                    array_push($arrData[$key]['desc'], $value->desc);
                }
                // 将多个图片路径并成数组
                if(empty($arrData[$key]['path'])){
                    $arrData[$key]['path'] = [$value->path];
                }else{
                    array_push($arrData[$key]['path'], $value->path);
                }
            }
        	return response()
            ->json(['status' => 0, 'message' => '获取成功', 'ps' => json_encode($arrData)])
            ->withCallback($request->input('callback'));
        }else{
        // $data->content = html_entity_decode($data->content);
            return response()
            ->json(['status' => 1, 'message' => '暂无数据'])
            ->withCallback($request->input('callback'));
        }
    }
    /**
     * 搜索
     */
    public function search(Request $request){
        $keys = $request->input('key');
        if(strlen($keys) < 1){
            return response()
            ->json(['status' => 2, 'message' => '参数缺失!'])
            ->withCallback($request->input('callback'));
        }
        $keyArr = explode(' ', $keys);
        $article = new Article;
        $data = $article->select('title','id')
                ->where('display', 1)
                ->where('title', 'like', "%{$keys}%")
                // ->orWhere('content', 'like', "%{$keys}%")
                ->get();
        if($data->count()){
            return response()
            ->json(['status' => 0, 'message' => '搜索成功', 'ps' => json_encode($data)])
            ->withCallback($request->input('callback'));
        }else{
            return response()
            ->json(['status' => 1, 'message' => '没有匹配内容'])
            ->withCallback($request->input('callback'));
        }
        
    }
    /**
     * 添加文本
     */
    private function addText($title, $content, $images=array(), $descs=array(),$cover='', $user=0, $usertemp=0){
        $display = 0;
        if($user != 0 && $usertemp == 0){
            $display = 1;
        }
    	$article = new Article;
    	$article->title = $title;
    	$article->content = $content;
        $article->user_id = (int)$user;
    	$article->user_temp_id = (int)$usertemp;
        $article->type = 1;
        $article->display = $display;
    	if($article->save()){
            $article->articleText()->create([
                'cover' => $cover,
            ]);
            if(count($images)){
                foreach($images as $key => $path){
                    if(stristr($content, $path)){
                        $article->articleImage()->create([
                            'desc' => @$descs[$key]? $descs[$key]:'',
                            'path' => @$path? $path:'',
                        ]);
                    }
                }
            }
            return $article->id;
        }else{
            return 0;
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
    /**
     * 判断是否为空
     */
    private function isEmpty($var, $default=null){
        if($var != null){
            return $var;
        }else{
            // dd($default);
            if($default != null){
                return $default;
            }else{
                return $var;
            }
        }
    }
}
