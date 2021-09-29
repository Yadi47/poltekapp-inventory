<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

 class AccessManagementController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Access Management';

        return view('access-management.access-management-index',$data);
    }

    public function userList(){
        $data['page_title'] = 'User List';
        $data['users'] = User::orderBy('id', 'DESC')->get();
        return view('access-management.users.users-list', $data);
    }

    public function userProfile(){
        $data['page_title'] = 'User Profile';
        $data['user'] = User::findOrFail(Auth::user()->id);
        $data ['roles'] = Role::get();
        return view('access-management.users.users-profile', $data);
    }

    public function userCreate(){
        $data['page_title'] = 'User Create';
        $data ['roles'] = Role::get();
        return view('access-management.users.users-create', $data);
    }

    public function userStore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'password' => 'required|string|min:4|confirmed',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('backend/images');
                $image->move($destinationPath, $name);
            }
            // User::create([ 
            //     'avatar' => $name,
            //     'name' => $request->name,
            //     'username' => $request->username,
            //     'email' => $request->email,
            //     'password' => Hash::make($request->password),
            // ])->assignRole($request->input('roles'));
            $data = new User;
            $data->username = $request->username;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->avatar = $request->avatar;
            $data->save();

            $data->assignRole($request->input('roles'));

            Session::flash('message', 'User Account Successfuly created !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('access-management.user-list');
        } catch (\Throwable $th){
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('access-management.user-list');
        }
    }

    public function userEdit($id){
        $data['page_title'] = 'user Edit';
        $data['user'] = User::find($id);
        $data ['roles'] = Role::get();
        return view('access-management.users.users-edit',$data);
    }

    public function userUpdate(Request $request, $id){
        if(isset($request->password)){
            $request->validate([
                'name' => "required|string|max:255|unique:users,name,$id",
                'username' => "required|string|max:255",
                'email' => "nullable|string|email|max:255",
                'password' => "required|string|min:3",
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }else{
            $request->validate([
                'name' => "required|string|max:255|unique:users,name,$id",
                'username' => "required|string|max:255",
                'email' => "nullable|string|email|max:255",
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);
        }
        try{
               $user = User::findOrFail($id);
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $name = rand(1, 100) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('backend/images');
                $image->move($destinationPath, $name);
                $avatar = $name;
            }else{
                $avatar = $user->avatar;
            }
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->avatar = $avatar;
            if (isset($request->password)) {
                $user->password = Hash::make($request->password);
            } 
            $user->save();

            $user->assignRole($request->input('roles'));
    
            Session::flash('message', 'User Account Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('access-management.user-list');
           } catch(\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('access-management.user-list');
           }
        // } else {
        //     $validated = $request->validate([
        //         'name' => "required|string|max:255|unique:users,name,$id",
        //         'username' => "required|string|max:255",
        //         'email' => "required|string|email|max:255|unique:users,email,$id",
        //     ]);
        //    try{
        //     DB::table('model_has_roles')->where('model_id',$id)->delete();

        //     $user = User::findOrFail($id);
        //     $user->name = $request->name;
        //     $user->username = $request->username;
        //     $user->email = $request->email;
        //     $user->save();

        //     $user->assignRole($request->input('roles'));
        //     Session::flash('message', 'User Account Successfuly updated !');
        //     Session::flash('alert-class', 'alert-success');
        //     return redirect()->route('access-management.user-list');
        //    } catch(\Throwable $th) {
        //     Session::flash('message', $th->getMessage());
        //     Session::flash('alert-class', 'alert-danger'); 
        //     return redirect()->route('access-management.user-list');
        //    }
        // }
        
    }
       public function userDelete(Request $request){
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success'); 
            User::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }

}
