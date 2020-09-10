@extends('admin.layouts.adminshop')
@section('content')
        <form class="layui-form"action="">
        <div class="layui-form-item">
            <label class="layui-form-label">品牌名称</label>
            <div class="layui-input-inline">
                <input type="text" name="brand_name"  value="{{$query['brand_name']??''}}" lay-verify="required" placeholder="请输入品牌名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">品牌网址</label>
            <div class="layui-input-inline">
                <input type="text" name="brand_url"  value="{{$query['brand_url']??''}}" lay-verify="required" placeholder="请输入品牌网址" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline">
                <button type="button" class="layui-btn">搜索</button>
            </div>
        </div>
        </form>
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col width="150">
                <col width="200">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="allcheckbox[]" lay-skin="primary"></th>
                <th>品牌ID</th>
                <th>品牌名称</th>
                <th>品牌logo</th>
                <th>品牌网址</th>
                <th>品牌简介</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($brand as $v)
                <tr>
                    <td><input type="checkbox" name="brandcheck[]" lay-skin="primary"></td>
                    <td>{{$v->brand_id}}</td>
                    <td><span class="brand_name">{{$v->brand_name}}</span></td>
                    <td>
                        @if($v->brand_logo)
                        <img src="{{$v->brand_logo}}" alt="">
                       @endif
                    </td>
                    <td>{{$v->brand_url}}</td>
                    <td>{{$v->brand_desc}}</td>
                    <td>
                        <a href="{{url('/brand/edit/'.$v->brand_id)}}" class="layui-btn ">编辑</a>
                        <a href="javascript:void(0)"  onclick="deleteByID({{$v->brand_id}},this)" class="layui-btn ">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tr>
                <td colspan="6">
                    {{$brand->appends($query)->links('vendor.pagination.adminshop')}}
                    <button type="button" class="layui-btu layui-but-normal moredel">批量删除</button>
                </td>
            </tr>
        </table>

        </div>
        @endsection
<script src="/static/admin/layui.js" charset="utf-8"></script>
<script src="/static/admin/js/jquery.min.js" charset="utf-8"></script>
<script>
    $(document).on('click','.brand_name',function () {
        var brand_name=$(this).text();
        var id=$(this).parent().attr('id');
        $(this).parent().html('<input type="text" class=" changename input_name_'+id+'" value='+brand_name+'>');
       $('.input_name_'+id).val('').focus().val(brand_name);
    });
    $(document).on('blur','.changename',function () {
        var newname=$(this).val();
        var id=$(this).parent().attr('id');
        var obj=$(this);
        $.get('/brand/change',{id:id,brand_name:newname},function (res) {
            if(res.code==0){
                obj.parent().html('<span class="brand_name"></span>');

            }
        },'json')
    });
    //JavaScript代码区域
    layui.use('element','form', function(){
        var element = layui.element;
        var form=layui.form;
    });
    $(document).on('click','layui-form-checkbox:first',function () {
        var checkedval=$('input[name="allcheckbox[]"]').prop('checked');
        $('input[name="brandcheck[]"]').prop('checked',checkedval);
        if(checkedval){
            $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
        }else{
            $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
        }

    });
    $('.moredel').click(function () {
        var ids=new  Array();
        $('input[name="brandcheck[]"]:checked').each(function (i,k) {

           ids.push($(this).val());
        });
        $.get('/brand/delete',{id:ids},function(res){
            alert(res.msg);
//            $(obj).parents('tr').remove();
            location.reload();
        },'json')
    });
   function  deleteByID(brand_id,obj){
       if(!brand_id){
           return;
       }
       $.get('/brand/delete/'+brand_id,function (res) {
           alert(res.msg);
           $(obj).parents('tr').hide();
       },'json')
   }
   $(document).on('click','layui-laypage a',function () {
//  alert(123123);
//   $('layui-laypage a').click(function () {
       var url=$(this).attr('href');
       $.get(url,function (res) {
           $('tbody').html(res);
           layui.use('element','form', function(){
               var element = layui.element;
               var form=layui.form;
               form.render();
           });
       })
       return false;
   })
</script>
</body>
</html>
