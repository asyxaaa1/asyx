
@foreach($brand as $v)
    <tr>
        <td>{{$v->brand_id}}</td>
        <td>{{$v->brand_name}}</td>
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
        </td>
    </tr>