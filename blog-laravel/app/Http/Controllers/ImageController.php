<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * 上传图片
     */
    public function image(Request $request){
    	if(count($request->all())){
            $temp = '';
            foreach ($request->all() as $key => $value) {
                if($request->hasFile($key)){
                    if($request->file($key)->isValid()){
                        if($request->file($key)->getClientSize() <= 10*1024*1024){
                            $arr = array('png','jpg','gif','jpeg','bmp','svg','webp');
                            $extension = strtolower($request->file($key)->getClientOriginalExtension());
                            if(in_array($extension, $arr)){
                                $fileName = date('Y-m-d_H-i-s_').time().rand(1000,9999).'.'.$extension;
                                $temp = $request->file($key)->storeAs('images', $fileName, 'public');
                                // return response()->json(['errno'=>0,'data'=>explode('/', $temp)[2]]);
                                \Illuminate\Support\Facades\DB::table('images')->insert([
                                	'name' => $fileName,
                                	'extension' => $extension,
                                	'path' => $temp,
                                	'desc' => '',
                                ]);
                                return response()
						        ->json(['status' => 0, 'message' => '上传成功!','ps'=>env('APP_URL','http://wwzc.cc').'/storage/'.$temp])
						        ->withCallback($request->input('callback'));
                            }
                        }
                    }

                }
            }
            return response()
	        ->json(['status' => 1, 'message' => '上传失败!'])
	        ->withCallback($request->input('callback'));

        }
    }
}
