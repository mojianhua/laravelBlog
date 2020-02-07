<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Cate;
use Image;
use Markdown;
use App\Services\OSS;
# 七牛配置
use Illuminate\Support\Facades\Storage;
use Redis;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listKey = "LIST:ARTICLE";
        $haskKey = "HASH:ARTICLE";

        //文章数据是否存在redis
        if(Redis::exists($listKey)){
            $article = [];
            //所有文章的id
            $lists = Redis::lrange($listKey,0,-1);
            foreach ($lists as $key => $value) {
                $article[] = Redis::hgetall($haskKey.$value);
            }
        }else{
            $article = Article::get()->toArray();
            foreach ($article as $key => $value) {
                //文件id存入listKey
                Redis::rpush($listKey,$value['art_id']);
                //文章数据存入HashKey
                Redis::hmset($haskKey.$value['art_id'],$value);
            }
        }

        //$input = $request->all();
        // $article = Article::OrderBy('art_id','asc')
        //         ->where(function($query) use ($request){
        //             $art_title = $request->input('art_title');
        //             if(!empty($art_title)){
        //                 $query->where('art_title','like','%'.$art_title.'%');
        //             }
        //         })
        //         ->paginate($request->input('num') ? $request->input('num') : 2);

        return view('admin.article.article_list',compact('article','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = Cate::get();
        return view('admin.article.article_add',compact('cate'));
    }

    public function upload(Request $request)
    {
        //获取上传文件
        $file = $request->file('photo');
        if (!$file->isValid()){
            return response()->json(['ServerNo'=>'400','ResultData'=>'无效的上传文件']);
        }
        // 文件扩展名
        $ext = $file->getClientOriginalExtension();
        // 新文件名
        $newFile = md5(time().rand(1000,9999)).'.'.$ext;
        //文件上传的指定路径
        $path = public_path('uploads');

        // //内置文件上传方法
        // //将文件从临时目录移到指定目录
        // if(!$file->move($path,$newFile)){
        //     return response()->json(['ServerNo'=>'400','ResultData'=>'文件保存失败']);
        // }

        //image扩展文件上传方法
        //$res = Image::make($file)->resize(100,100)->save($path.'/'.$newFile);

        // //2. 将文件上传到OSS的指定仓库
       // $osskey : 文件上传到oss仓库后的新文件名
       // $filePath:要上传的文件资源
       // $res = OSS::upload($newFile, $file->getRealPath());

        //3. 将文件上传到七牛云存储的指定仓库
        $qiniu = Storage::disk('qiniu');

        $res = \Storage::disk('qiniu')->writeStream($newFile, fopen($file->getRealPath(), 'r'));
        if ($res){
            return response()->json(['ServerNo'=>'200','ResultData'=>$newFile]);
        }else{
            return response()->json(['ServerNo'=>'400','ResultData'=>'文件上传失败']);
        }
    }

    public function pre_mk(Request $request){
        return Markdown::convertToHtml($request->cont);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
