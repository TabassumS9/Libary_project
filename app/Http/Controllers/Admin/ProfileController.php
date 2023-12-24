<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Admin as AdminAdmin;

class ProfileController extends Controller
{
    //admin Profile Page
    public function index(){
        return view('admin.profile.admin_profile');
    }
   
    //* PROFILE DATA
    function updateProfile(Request $request){
        //dd($request ->all());
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:admins,email,'.auth()->guard("admin")->user()->id ,
            'phoneNumber'=> 'numeric',
            'address'=> 'required',
        
        ],[ 'name.required'=>'Enter your user name'
        ]);


        // admin data update

        $admin= AdminAdmin::find(auth()->guard('admin')->user()->id);
        $admin->name =$request->name;
        $admin->email =$request->email;
        $admin->phone =$request->phoneNumber;
        $admin->address =$request->address;
        $admin->save();
        return back();

    // *PROFILE IMAGE UPLOAD
    function imgUpload(Request $request){
        $request->validate([
           'profile' => 'nullable|mimes:jpg,png',
        ]);
        if($request->hasFile('profile')){
            $ext = $request->profile->extension();
            $img_name = auth()->guard('admin')->user()->name . '-' . Carbon::now()->format('d-m-y-h-m-s') . '.' .$ext ;
            $request->profile->storeAs('Profile_img', $img_name, 'public');
        } 
        //*Profile img DATA UPDATE
        $user = AdminAdmin::find(auth()->guard('admin')->user()->id);
        $user->profile = $img_name;
        $user->save();
        return back();
    }
    // *PASSWORD UPDATE
    function updatePassword(Request $request){
        dd(auth()->guard('admin')->user()->id);
        $request->validate([
            'password' => "required|current_password",
            'new_password' => "required|confirmed|different:password",
            'new_password_confirmation' => "required",
        ]);

        $user = AdminAdmin::find(auth()->guard('admin')->user()->id );
        $user->new_password = Hash::make($request->new_password);
        $user->save();
        return back();
    }
    
}
}
