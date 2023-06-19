<?php

namespace App\Http\Controllers\Api;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use DB;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
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
         //
         $validateData =  $request->validate([
            'name'=>'required|max:255',
        ]);

        if($request->photo){
            $position = strpos($request->photo, ';');
            $sub=substr($request->photo, 0 ,$position);
            $ext=explode('/', $sub)[1];
            $name=time().".".$ext;
            $img=Image::make($request->photo)->resize(240,200);
            $upload_path='backend/brand/';
            $image_url=$upload_path.$name;
            $img->save($image_url);

            $brand = new Brand;
            $brand->name = $request->name;
            $brand->image =  $image_url;
            $brand->save();
     }else{
            $brand = new Brand;
            $brand->name = $request->name;
            $brand->save();
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
        $brand = DB::table('brands')->where('id',$id)->first();
        return response()->json($brand);
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
        $data = array();
        $data['name'] = $request->name;
    if($request->newPhoto){
        $position = strpos($request->newPhoto,';');
        $sub      = substr($request->newPhoto,0,$position);
        $ext      = explode('/',$sub)[1];
        $name     = time().".".$ext;
        $img      = Image::make($request->newPhoto)->resize(240,200);
        $upload_path = 'backend/brand/';
        $image_url   = $upload_path.$name;
        $save        = $img->save($image_url);
    }
    if($save){
        $data['image'] = $image_url;
        $img = DB::table('brands')->where('id',$id)->first();
        $img_path = $img->image;
        if($img_path){
            unlink($img_path);
        }
    }
        $brand = DB::table('brands')->where('id',$id)->update($data);
        
    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =  DB::table('brands')->where('id',$id)->first();
        if($category->image){
            DB::table('brands')->where('id',$id)->delete();
            unlink($category->image);
        }else{
            DB::table('brands')->where('id',$id)->delete();
        }
    }
}
