<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$employee = EmployeeModel::all();
        $employee = DB::table('employees')->get();
        return response()->json($employee);
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
        $validatedData = $request->validate([
            'name' => 'required|unique:employees|max:255',
            'email' => 'required',
            'number' => 'required|unique:employees',
           ]);
   
               if($request->photo){
                      $position = strpos($request->photo, ';');
                      $sub=substr($request->photo, 0 ,$position);
                      $ext=explode('/', $sub)[1];
                      $name=time().".".$ext;
                      $img=Image::make($request->photo)->resize(240,200);
                      $upload_path='backend/employee/';
                      $image_url=$upload_path.$name;
                      $img->save($image_url);
   
                      $employee = new Employee;
                      $employee->name = $request->name;
                      $employee->email = $request->email;
                      $employee->number = $request->number;
                      $employee->address = $request->address;
                      $employee->salary = $request->salary;
                      $employee->nid = $request->nid;
                      $employee->joining_date = $request->joining_date;
                      $employee->photo =  $image_url;
                      $employee->save();
               }else{
                      $employee = new Employee;
                      $employee->name = $request->name;
                      $employee->email = $request->email;
                      $employee->number = $request->number;
                      $employee->address = $request->address;
                      $employee->salary = $request->salary;
                      $employee->nid = $request->nid;
                      $employee->joining_date = $request->joining_date;
                      $employee->save();
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
        $employee =  DB::table('employees')->where('id',$id)->first();
        if($employee->photo){
            DB::table('employees')->where('id',$id)->delete();
            unlink($employee->photo);
        }else{
            DB::table('employees')->where('id',$id)->delete();
        }
        
    }
}
