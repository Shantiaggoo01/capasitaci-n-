<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use App\Http\Controllers\redirect;
use Illuminate\support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\support\Facades\DB;
use Illuminate\support\Facades\Host;
use Illuminate\support\Arr;
use App\Http\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;


use Illuminate\Support\Facades\Auth;







class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|borrar-usuario|Ver-Menu-Configuracion|Ver-Menu-Compras|Ver-Menu-Produccion|ver-Menu-Reportes|Ver-Menu-Ventas')->only('index');
        $this->middleware('permission:crear-usuario', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-usuario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-usuario', ['only' => ['destroy']]);
        $this->middleware('permission:asignar-roles', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Empleado')) {
            $users = ModelsUser::where('id', $user->id)->paginate();
        } else {
            $users = ModelsUser::paginate();
        }

        return view('usuarios.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        unset($roles['Administrador']);

        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // agrego esto
    public function store(Request $request)
    {
        $this->validate($request, [
            'documento' => 'required|numeric|min:10|unique:users',
            'name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'regex:/^[\pL\s]+$/u'],
            'telefono' => 'required|numeric',
            'direccion' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['image'] = $image->getClientOriginalName();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['image']);
        }

        $user = ModelsUser::create($input);
        $user->syncRoles($request->input('roles')); // asignar roles al usuario creado

        // Agregar el permiso "editar-usuario" al usuario recién creado
        $permission = Permission::findByName('editar-usuario');
        $user->givePermissionTo($permission);



        return redirect()->route('usuarios.index')->with('success', 'Se agregó correctamente')->with('reload', true);
    }

    public function edit($id)
    {
        $user = ModelsUser::find($id);

        // Verifica si el usuario que ha iniciado sesión tiene permisos para editar este perfil
        if ($user->id !== Auth::user()->id && !Auth::user()->hasRole('Administrador')) {
            return redirect()->route('usuarios.index')->with('error', 'No tienes permiso para editar este perfil');
        }

        // Verifica si el usuario es el superadministrador
        if ($user->hasRole('Administrador')) {
            return redirect()->back()->with('error', 'No puedes editar al super administrador');
        }

        $roles = Role::pluck('name', 'name')->all();
        unset($roles['Administrador']);

        $selectedRoles = $user->roles()->pluck('name')->toArray();

        return view('usuarios.edit', compact('user', 'roles', 'selectedRoles'));
    }

    public function update(Request $request, $id)
    {
        $user = ModelsUser::find($id);



        // Continúa con la edición del usuario
        $this->validate($request, [
            'name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'regex:/^[\pL\s]+$/u'],
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            //'roles' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        // Subir la imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $input['image'] = $name;
        }

        // Verifica si el usuario es el superadministrador
        if ($user->hasRole('Administrador')) {
            // Si el usuario es el superadministrador, no se puede editar su rol
            $input = Arr::except($input, array('roles'));
            return redirect()->route('usuarios.index')->with('error', 'No puedes editar al super administrador');
        } else {
            // Si el usuario no es el superadministrador, se puede editar su rol
            $user->syncRoles($request->input('roles'));
            $user->update($input);

            Session::flash('success', 'Se actualizó correctamente');
            return redirect()->route('usuarios.show', $id)->with('success', 'Se actualizó correctamente')->with('reload', true);
        }
    }


    public function show($id)
    {

        $user = ModelsUser::findOrFail($id);

        // Verifica si el usuario es el administrador o si es el usuario que inició sesión
        if (!Auth::user()->hasRole('Administrador') && $user->id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'No tienes permiso para ver este perfil');
        }

        //dd($user);

        return view('usuarios.show', compact('user'));
    }

    public function activar($id)
    {
        $user = ModelsUser::findOrFail($id);
        $user->estado = 1;
        $user->save();

        return redirect()->back()->with('success', 'El usuario ha sido activado correctamente.')->with('reload', true);
    }

    public function desactivar($id)
    {
        $user = ModelsUser::findOrFail($id);
        $user->estado = 0;
        $user->save();

        return redirect()->back()->with('success', 'El usuario ha sido inactivado correctamente.')->with('reload', true);
    }
}
