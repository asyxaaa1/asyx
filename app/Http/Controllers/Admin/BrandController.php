<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\StoreBrandPost;
use Validator;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand_name=request()->brand_name;
       $where=[];
       if($brand_name){
           $where[]=['brand_name','like',"%$brand_name%"];
       }
        $brand_url=request()->brand_url;
        $where=[];
        if($brand_url){
            $where[]=['brand_name','like',"%$brand_url%"];
        }
        $brand=Brand::where($where)->orderBy('brand_id','desc')->paginate(5);
        if(request()->ajax()){
            return view('admin.brand.index',['brand'=>$brand,'query'=>request()->all()]);
        }
        return view('admin.brand.index',['brand'=>$brand,'query'=>request()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.brand.create');
    }


    public function upload(Request $request){
       if($request->hasFile('file')&& $request->file('file')->isValid()){
           $photo=$request->file('file');
           $img_src=env('IMG_URL').$photo->store('upload');
          return json_encode(['code'=>0,'msg'=>'上传成功','data'=>$img_src]);
       }
        return json_encode(['code'=>2,'msg'=>'上传失败']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $post=$request->except(['_token','file']);
        $res=Brand::create($post);
        if($res){
            return redirect('/brand');
        }
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
        $data = Brand::find($id);
        //dd($data);
        return view('admin.brand.edit',['data'=>$data]);
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
        $post=$request->except(['_token','file']);

//        if($request->hasFile('brand_logo')){
//            $post['brand_logo'] = $this->upload('brand_logo');
//        }
        //更新入库
        $res=Brand::where('brand_id',$id)->update($post);
        if($res!==false){
            return redirect('/brand');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $id=request()->id?:$id;
        if(!$id){
            return;
        }
        $res = Brand::destroy($id);

        if(request()->ajax()){
            return response()->json(['code'=>'0','msg'=>'删除成功']);
        }
        if ($res) {
            return redirect('/brand');
        }
    }
    public  function  change(Request $request){
        $brand_name=$request->brand_name;
        $id=$request->id;

        if(!$brand_name || !$id){
            return response()->json(['code'=>3,'msg'=>'缺少参数']);
        }
      $res= Brand::where('brand_id',$id)->update(['brand_name'=>$brand_name]);
     if($res){
         return response()->json(['code'=>0,'msg'=>'修改成功']);
     }
    }

}
