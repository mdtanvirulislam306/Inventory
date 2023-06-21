<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        //view product
        $products = DB::table('products')
            ->join('suppliers', 'products.supplier_id','suppliers.id')
            ->join('categories', 'products.category_id','categories.id')
            ->join('brands', 'products.brand_id','brands.id')
            ->select('products.*', 'suppliers.supplier_name','categories.category_name','brands.brand_name')
            ->get();
        return response()->json($products);
    }
    public function store(Request $request)
    {
        //
        

        if($request->photo){
            $position = strpos($request->photo, ';');
            $sub=substr($request->photo, 0 ,$position);
            $ext=explode('/', $sub)[1];
            $name=time().".".$ext;
            $img=Image::make($request->photo)->resize(240,200);
            $upload_path='backend/product/';
            $image_url=$upload_path.$name;
            $img->save($image_url);

            $product = new Product();
            $product->product_name = $request->product_name;
            $product->supplier_id = $request->supplier_id;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->purchase_price = $request->purchase_price;
            $product->selling_price = $request->selling_price;
            $product->qty = $request->qty;
            $product->purchase_date = $request->purchase_date;
            $product->expair_date = $request->expair_date;
            $product->image =  $image_url;
            $product->save();
     }else{
            $product = new Product;
            $product->product_name = $request->product_name;
            $product->supplier_id = $request->supplier_id;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->purchase_price = $request->purchase_price;
            $product->selling_price = $request->selling_price;
            $product->qty = $request->qty;
            $product->purchase_date = $request->purchase_date;
            $product->expaire_date = $request->expair_date;
            $product->save();
     }
    }

}
