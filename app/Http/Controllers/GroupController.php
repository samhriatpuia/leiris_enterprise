<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::orderBy('created_at', 'desc')
                        ->paginate(2);
        return Inertia::render('Group/Index',['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            

        ]);
        // dd($request->name);
        Group::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);
        sleep(1);

        return redirect()->route('groups.index')->with('message', 'Group Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $group=Group::findOrFail($id);


        return Inertia::render('Group/Edit',compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $group=Group::findOrFail($request->id);
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

       
        $group->name = $request->name;
        $group->type = $request->type;
        
       
        $group->save();
        

        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group=Group::findOrFail($id);

        $group->delete();

        return redirect()->route('groups.index')->with('message', 'Expense Updated Successfully');
    }


    public function search(Request $request)
    {
        // dd($request->search_data);
        $groups=Group::where('name','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Group/Index',compact('groups'));
        
    }
}
