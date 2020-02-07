<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conf = Config::get();
        foreach ($conf as $key => $value) {
            switch($value->field_type){
                case 'input':
                    $value->conf_contents ='<input value="'.$value->conf_content.'" type="text" name="conf_content[]"  class="layui-input">';
                    break;
                case 'textarea':
                    $value->conf_contents ='<textarea name="conf_content[]" class="layui-textarea">'.$value->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $field_value = explode(',', $value->field_value);
                    $str = '';
                    foreach ($field_value as $k => $v) {
                        $aval = explode('|', $v);
                        if($aval[0] == $value->conf_content){
                            $str .= '<input type="radio" checked name="conf_content[]" value="'.$aval[0].'" title="'.$aval[1].'">'.$aval[1].'';
                        }else{
                            $str .= '<input type="radio" name="conf_content[]" value="'.$aval[0].'" title="'.$aval[1].'">'.$aval[1].'';
                        }
                    }
                    $value->conf_contents = $str;
                    break;
            }
        }
        return view('admin.config.config_list',compact('conf','request'));
    }

    //将网站配置数据表中的网站配置数据写入config/webconfig.php文件中
    public function putContent()
    {
        //1. 从网站配置表中获取网站配置数据
        //读取config的conf_content和conf_name字段内容
        $content = Config::pluck('conf_content','conf_name')->all();
        //2. 准备要写入的内容

        $str = '<?php return '.var_export($content,true).';';

        //3. 将内容写入webconfig.php文件

        file_put_contents(config_path().'/webconfig.php',$str);
    }

    //批量修改网站配置项的方法
    public function changeContent(Request $request)
    {
        $input = $request->except('_token');
        DB::beginTransaction();
        try{
            foreach ($input['conf_id'] as $k=>$v){
                DB::table('config')->where('conf_id',$v)->
                    update(['conf_content'=>$input['conf_content'][$k]]);
            }

            DB::commit();
            $this->putContent();
            return redirect('/Admin/config');

        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error'=>$e->getMessage()]);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
