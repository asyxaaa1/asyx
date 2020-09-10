@extends('admin.layouts.adminshop')
@section('content')
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">商品管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">添加商品</a></dd>
                        <dd><a href="javascript:;">列表商品</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">商品品牌</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">品牌添加</a></dd>
                        <dd><a href="javascript:;">品牌展示</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">云市场</a></li>
                <li class="layui-nav-item"><a href="">发布商品</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
            <legend>
                <span class="layui-breadcrumb">
                  <a href="/">首页</a>
                  <a href="/demo/">演示</a>
                  <a><cite>导航元素</cite></a>
                </span>
            </legend>
        </fieldset>
        <div style="padding: 15px;">
            <form class="layui-form" action="{{url('/brand/store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="brand_name" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌logo</label>
                    <div class="layui-input-block">
                        <div class="layui-upload-drag" id="test10">
                            <i class="layui-icon"></i>
                            <p>点击上传，或将文件拖拽到此处</p>
                            <div class="layui-hide" id="uploadDemoView">
                                <hr>
                                <img src="" alt="上传成功后渲染" style="max-width: 196px">
                            </div>
                        </div>
                        <input type="hidden" name="brand_logo"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌网址</label>
                    <div class="layui-input-block">
                        <input type="text" name="brand_url" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">品牌简介</label>
                    <div class="layui-input-block">
                        <input type="text" name="brand_desc" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" align="center">
                    <button type="submit" class="layui-btn layui-btn-primary">添加</button>
                    <button type="button" class="layui-btn layui-btn-primary">重置</button>
                </div>
       </form>
        </div>
    </div>
<script src="/static/admin/layui.js" charset="utf-8"></script>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
    layui.use('upload', function() {
        var $ = layui.jquery
            ,upload = layui.upload;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //拖拽上传
        upload.render({
            elem: '#test10'
            , url: 'http://2001.syx.com/brand/upload' //改成您自己的上传接口
            , done: function (res) {
                layer.msg(res.msg);
                layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data);
//               console.log(res);
                layui.$('input[name="brand_logo"]').attr('value',res.data);
            }
        });
    });
</script>
    @endsection
