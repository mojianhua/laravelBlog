<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        @include('admin.public.style')
        @include('admin.public.js')
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" id="art_form">
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>父级分类
                        </label>
                        <div class="layui-input-inline">
                            <select name="cate_pid">
                                <option value="0">==顶级分类==</option>
                                @foreach($cate as $v)
                                <option value="{{ $v->cate_id }}">{{ $v->cate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="layui-form-mid layui-word-aux">
                            <span class="x-red">*</span>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>文章标题</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_email" name="art_title" required="" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            <span class="x-red">*</span>文章标签</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_pass" name="art_tag" required="" autocomplete="off" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">缩略图</label>
                        <div class="layui-input-block layui-upload">
                            <input type="hidden" id="img1" class="hidden" name="art_thumb" value="">
                            <button type="button" class="layui-btn" id="test1">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                            <input type="file" name="photo" id="photo_upload" style="display: none;" />
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <img src="" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
                        </div>
                    </div>

                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">输入markdown语法内容</li>
                            <li id="previewBtn">预览Html语法的内容</li>

                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <textarea id="z-textarea" name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
                            </div>
                            <div class="layui-tab-item">
                                <textarea id="z-textarea-preview" name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
                            </div>

                        </div>
                    </div>

                    <!--
                    <div class="layui-input-block">
                        <p>百度编辑器使用方法</p>
                        <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
                        <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
                        <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>


                        <script id="editor" type="text/plain" name="art_content" style="width:600px;height:300px;"></script>
                        <script type="text/javascript">

                        //实例化编辑器
                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                        var ue = UE.getEditor('editor');
                        </script>
                    </div>
                    -->

                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
                </form>
            </div>
        </div>
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });

        //Markdown AJAX
        $('#previewBtn').click(function(){
            $.ajax({
                url:"/Admin/article/pre_mk",
                type:"post",
                data:{cont:$('#z-textarea').val()},
                success:function(res){
                    $('#z-textarea-preview').html(res);
                },
                error:function(err){
                    console.log(err.responseText);
                }
            });
        });


    </script>
    <script>
        layui.use(['form','layer','upload','element'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
          var upload = layui.upload;
            var element = layui.element;

          $('#test1').on('click',function () {
                $('#photo_upload').trigger('click');
                $('#photo_upload').on('change',function () {
                    var obj = this;
                    var formData = new FormData($('#art_form')[0]);
                    console.log(formData);
                    $.ajax({
                        url: '/Admin/article/upload',
                        type: 'post',
                        data: formData,
                        // 因为data值是FormData对象，不需要对数据做处理
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data['ServerNo']=='200'){
                                //存入阿里云返回设置
                                 $('#art_thumb_img').attr('src', '{{ env('ALIOSS_DOMAIN')  }}'+data['ResultData']);
                                // 如果成功(不存入云)
                                // $('#art_thumb_img').attr('src', '/uploads/'+data['ResultData']);
                                // $('input[name=art_thumb]').val('/uploads/'+data['ResultData']);
                                $(obj).off('change');
                            }else{
                                // 如果失败
                                alert(data['ResultData']);
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            var number = XMLHttpRequest.status;
                            var info = "错误号"+number+"文件上传失败!";
                            // 将菊花换成原图
                            // $('#pic').attr('src', '/file.png');
                            alert(info);
                        },
                        async: true
                    });
                });

          });

          //监听提交
          form.on('submit(add)', function(data){

          });
          
          
        });
    </script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>