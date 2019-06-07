<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        
        return view ("users.show", [
            "user" => $user,
            ]);
    }
    
    public function edit($id){
        $user = User::find($id);
        
        return view("users.edit", [
            "user" => $user,
            ]);
    }
    
    public function update(Request $request, $id){
        
    }
    
    public function destroy($id){
        $user = User::find($id);
        
        $user->delete();
        
        return back();
    }
}
