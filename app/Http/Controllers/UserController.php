<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::where('role','=','guest')->get();
        return view('admin.users', compact('users'));
    }

    public function create(){
        return view('admin.addUser');
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if($validate){
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 'guest',
            ]);
            return redirect()->route('users.index');
        }
        return redirect()->back();
    }

    public function destroy(Request $request, User $user){
        $user = User::where('id','=',$user->id)->first();
        if($user->count() > 0){
            $user->delete();
        }

        return redirect()->route('users.index');

    }
}
