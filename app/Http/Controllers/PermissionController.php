<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
class PermissionController extends Controller
{
    public function index(){
        $data['page_title'] = 'Permission List';
        $data['permissions'] = Permission::orderBy('id','desc')->get();
        return view('access-management.permissions.permission-list',$data);
    }

    public function create(){
        $data['page_title'] = 'Permission Create';
        return view('access-management.permissions.permission-create',$data);
    }

    public function edit($id){
        $data['page_title'] = 'Permission Edit';
        $data['permission'] = Permission::find($id);
        return view('access-management.permissions.permission-edit',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|unique:permissions|max:255|alpha_dash',
        ]);
        try {
            Permission::create(['name' => $request->name]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('access-management.permission-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('access-management.permission-list');
        }
    }
    public function update(Request $request,$id){
        $validated = $request->validate([
            'name' => "required|max:255|alpha_dash|unique:permissions,name,$id"
        ]);
        try {
            Permission::where('id',$id)->update(['name' => $request->name]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('access-management.permission-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('access-management.permission-list');
        }
    }
    public function delete(Request $request){
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success'); 
            Permission::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
