<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Image; 
use Illuminate\Support\Facades\DB;
class SupplierController extends Controller
{
   
    public function index()
    {
        //
        $suppliers = Supplier::all();
        return response()->json($suppliers);
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
        $validateData =  $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|unique:suppliers',
            'number'=>'required|unique:suppliers',
        ]);

        if($request->photo){
            $position = strpos($request->photo, ';');
            $sub=substr($request->photo, 0 ,$position);
            $ext=explode('/', $sub)[1];
            $name=time().".".$ext;
            $img=Image::make($request->photo)->resize(240,200);
            $upload_path='backend/supplier/';
            $image_url=$upload_path.$name;
            $img->save($image_url);

            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->number = $request->number;
            $supplier->address = $request->address;
            $supplier->nid = $request->nid;
            $supplier->shop_name = $request->shop_name;
            $supplier->photo =  $image_url;
            $supplier->save();
     }else{
            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->number = $request->number;
            $supplier->address = $request->address;
            $supplier->nid = $request->nid;
            $supplier->shop_name = $request->shop_name;
            $supplier->save();
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
        $supplier = DB::table('suppliers')->where('id',$id)->first();
        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['number'] = $request->number;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['shop_name'] = $request->shop_name;
    if($request->newPhoto){
        $position = strpos($request->newPhoto,';');
        $sub      = substr($request->newPhoto,0,$position);
        $ext      = explode('/',$sub)[1];
        $name     = time().".".$ext;
        $img      = Image::make($request->newPhoto)->resize(240,200);
        $upload_path = 'backend/supplier/';
        $image_url   = $upload_path.$name;
        $save        = $img->save($image_url);
    if($save){
        $data['photo'] = $image_url;
        $img = DB::table('suppliers')->where('id',$id)->first();
        $img_path = $img->photo;
        if($img_path){
            unlink($img_path);
        }
        $user = DB::table('suppliers')->where('id',$id)->update($data);
        }
    }else{
        $oldImg = $request->photo;
        $data['photo'] =  $oldImg;
        $user = DB::table('suppliers')->where('id',$id)->update($data);
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier =  DB::table('suppliers')->where('id',$id)->first();
        if($supplier->photo){
            DB::table('suppliers')->where('id',$id)->delete();
            unlink($supplier->photo);
        }else{
            DB::table('suppliers')->where('id',$id)->delete();
        }
    }
}
