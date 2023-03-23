<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Agregamos

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\support\Facades\DB;

class RolController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol')->only('index');
        $this->middleware('permission:crear-rol', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-rol', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission =  Permission::get();
        return view('roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles|regex:/^[\pL\s]+$/u',
            'permission' => 'required'
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success', 'Se registró con éxito')->with('reload', true);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        $role = DB::table('roles')->where('id', $id)->first();
        if ($role->name == 'Administrador') {
            return redirect()->route('roles.index')->with('error', 'No se puede editar el rol de administrador')->with('reload', true);
        }

        if ($role->name == 'Empleado') {
            return redirect()->route('roles.index')->with('error', 'No se puede editar el rol empleado predeterminado')->with('reload', true);
        }


        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'permission' => 'required'
        ]);

        // Verificar si existe otro rol con el mismo nombre
        $existingRole = Role::where('name', $request->input('name'))->where('id', '!=', $id)->first();
        if ($existingRole) {
            return redirect()->route('roles.edit', $id)->with('error', 'El nombre del rol ya existe en la base de datos');
        }


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('success', 'Se actualizó con éxito')->with('reload', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);

        if ($role->name == 'Administrador') {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol de administrador')->with('reload', true);
        }

        if ($role->name == 'Empleado') {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol empleado predeterminado')->with('reload', true);
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'No se puede eliminar el rol porque hay usuarios asignados a él')->with('reload', true);
        }


        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Se eliminó con éxito')->with('reload', true);
    }

    public function showPermissions($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;

        return view('roles.permissions', compact('role', 'permissions'));
    }
}
