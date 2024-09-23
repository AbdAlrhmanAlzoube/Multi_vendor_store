<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{

    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
        $this->authorizeResource(Role::class,'role');
     }


    public function index()
    {
        $roles=Role::paginate();
        return view('dashboard.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles.create',[
            'role'=>new Role(),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'string|required|max:255',
            'abilities'=>'required|array',
        ]);
        $role=Role::createWithAbilites($request);
        // dd('abd');
        return redirect()
        ->route('dashboard.roles.index')
        ->with('success','Role Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role_abilities=$role->abilities()->pluck('type','ability')->toArray();
        // dd($role_abilities);
        return view ('dashboard.roles.edit',compact('role','role_abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'string|required|max:255',
        'abilities' => 'required|array',
    ]);

    // Call the instance method on the $role object
    $role->updateWithAbilities($request);

    return redirect()
        ->route('dashboard.roles.index')
        ->with('success', 'Role updated successfully');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       Role::destroy($id);
       return redirect()
       ->route('dashboard.roles.index')
       ->with('success','Role Deleted Successfully');
   
    }
}
