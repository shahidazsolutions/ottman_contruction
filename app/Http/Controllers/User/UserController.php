<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    function index() {
        return view('role.list');
    }
    
    function add() {
        return view('role.add');
    }
    public function insert(Request $request)  {
        
        $input = $request->validate([
            'name'  	        => 'required',
        ]);
        Role::create($input);
        return redirect()->back()->with('success','Success Purchase Inserted');
    }
}
