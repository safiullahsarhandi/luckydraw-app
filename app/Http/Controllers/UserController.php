<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(10);
        return response()->json(compact('users'));
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        User::make()->
        forceFill($request->all())
        ->save();
        return response()->json(['status' => true,'message' => 'Member created successfully']);
    }
}
