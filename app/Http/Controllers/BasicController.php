<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Group;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;


class BasicController extends Controller
{
    public function index()
    {
        $users=User::where('role','!=','admin')->paginate(10);

        return Inertia::render('User/Index',compact('users'));
    }

    public function edit($id)
    {
        $user=User::findOrFail($id);

        return Inertia::render('User/Edit',compact('user'));
    }


    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role'=>'required',   
            'password'=>'required',      
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role'=> $request->role,
            'password'=> Hash::make($request->password),
        ]);

        $users=User::where('role','!=','admin')->paginate(10);

        return Inertia::render('User/Index',compact('users'));
    }

    public function update(Request $request)
    {
        $user=User::findOrFail($request->id);
        // dd($request->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role'=>'required',         
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if($request->password !="")
        {
            $user->password=Hash::make($request->password);
        }
        $user->save();
        $users=User::where('role','!=','admin')->paginate(10);

        return Inertia::render('User/Index',compact('users'));

    }
}
