<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function profile(){
        $admin = Auth::user();

        return view('profile.index',compact('admin'));
    }

    public function update(Request $request){


        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email',
            'profile'=>'nullable',
            'password'=>'nullable|confirmed|min:8'
        ]);

        $user = Auth::user();
        $user = User::find($user->id);

        $user->name=$request->name;
        $user->email=$request->email;
        if ($request->hasFile('profile')) {

            if($user->profile && file_exists(public_path() . '/images/admin/'.$user->profile)){
                unlink(public_path() . '/images/admin/'.$user->profile);
            }
            $file = $request->profile;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/admin';
            $filename= rand(100000,999999).$filename;
            $file->move($destinationPath, $filename);
            $user->profile = $filename;


        }
        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->back()->with('success','profile updated');

    }

}

