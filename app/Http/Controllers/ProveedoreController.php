<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use App\Models\TipoProveedor;
use App\Models\Regiman;
use App\Models\TiposCuenta;
use Illuminate\Http\Request;

//Agregamos 

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\support\Facades\DB;

/**
 * Class ProveedoreController
 * @package App\Http\Controllers
 */
class ProveedoreController extends Controller
{

    // si habilito esta funcion se supone que debe de dar permisos ---
    function __construct()
    {
        $this->middleware('permission:ver-proveedor|crear-proveedor|editar-proveedor|borrar-proveedor|Ver-Menu-Configuracion|ver-Menu-Compras|Ver-Menu-Produccion|ver-Menu-Reportes|Ver-Menu-Ventas|cambiar-estado')->only('index');
        $this->middleware('permission:crear-proveedor' , ['only' => ['create','store']]);
        $this->middleware('permission:editar-proveedor' , ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-proveedor' , ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      
        $proveedores = Proveedore::paginate();
        $tipo_proveedors = TipoProveedor::pluck('nombre', 'id');
        return view('proveedore.index', compact('proveedores', 'tipo_proveedors'))
            ->with('i', (request()->input('page', 1) - 1) * $proveedores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedore = new Proveedore();
        $regimen = Regiman::pluck('nombre', 'id');
        $tiposCuenta = TiposCuenta::pluck('nombre', 'id');
        $tipo_proveedors = TipoProveedor::pluck('nombre', 'id');
        return view('proveedore.create', compact('proveedore', 'tipo_proveedors', 'regimen', 'tiposCuenta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validacion de los campos
        $request->validate([
            'nit' => 'required|numeric|unique:proveedores,nit,except,id',
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|numeric',
            'banco' => 'required|string',
            'cuenta' => 'required|numeric',
            'idtipo_proveedor' => 'required',
            'razon_social' => 'required|string',
            'NombreContacto' => 'required|string',
            'TelefonoContacto' => 'required|numeric',
            'regimen_id' => 'required',
            'cuenta_id' => 'required',
        ]);
        //convertir el select a un booleano
        $estado = $request->estado == 'on' ? 1 : 0;
        request()->validate(Proveedore::$rules);
        $user = auth()->user();
        $proveedore = new Proveedore();
        $proveedore->nit = $request->nit;
        $proveedore->nombre = $request->nombre;
        $proveedore->direccion = $request->direccion;
        $proveedore->telefono = $request->telefono;
        $proveedore->banco = $request->banco;
        $proveedore->cuenta = $request->cuenta;
        $proveedore->idtipo_proveedor = $request->idtipo_proveedor;
        $proveedore->razon_social = $request->razon_social;
        $proveedore->NombreContacto = $request->NombreContacto;
        $proveedore->TelefonoContacto = $request->TelefonoContacto;
        $proveedore->regimen_id = $request->regimen_id;
        $proveedore->cuenta_id = $request->cuenta_id;
        $proveedore->user_id = $user->id;
        $proveedore->save();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }
    public function updateStatus($id)
{
    $provider = Proveedore::findOrFail($id);
    $provider->update(['estado' => ! $provider->estado]);

    return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
}


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedore = Proveedore::find($id);
        //encontrar el tipo de proveedor por el id del proveedor y luego el nombre
        $proveedore = Proveedore::join('tipo_proveedor', 'proveedores.idtipo_proveedor', '=', 'tipo_proveedor.id')
        ->join('regimen', 'proveedores.regimen_id', '=', 'regimen.id')
        ->join('tiposcuentas', 'proveedores.cuenta_id', '=', 'tiposcuentas.id')
        ->with('user')
        ->select('proveedores.*', 'tipo_proveedor.nombre as tipo_proveedor', 'regimen.nombre as regimen', 'tiposcuentas.nombre as tipos_cuenta')
        ->where('proveedores.id', $id)
        ->first();
        $user = Proveedore::with('user')->find($id);
        return view('proveedore.show', compact('proveedore', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipo_proveedors = TipoProveedor::pluck('nombre', 'id');
        $regimen = Regiman::pluck('nombre', 'id');
        $tiposCuenta = TiposCuenta::pluck('nombre', 'id');
        $proveedore = Proveedore::find($id);
        return view('proveedore.edit', compact('proveedore', 'tipo_proveedors', 'regimen', 'tiposCuenta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Proveedore $proveedore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $proveedore = Proveedore::find($id);
    $request->validate([
        'nit' => 'required|unique:proveedores,nit,'.$proveedore->id,
        'nombre' => 'required|string',
        'direccion' => 'required|string',
        'telefono' => 'required|numeric',
        'banco' => 'required|string',
        'cuenta' => 'required|numeric',
        'idtipo_proveedor' => 'required',
        'razon_social' => 'required|string',
        'NombreContacto' => 'required|string',
        'TelefonoContacto' => 'required|numeric',
        'regimen_id' => 'required',
        'cuenta_id' => 'required',
    ]);

    $proveedore = Proveedore::find($id);
    $proveedore->nit = $request->nit;
    $proveedore->nombre = $request->nombre;
    $proveedore->direccion = $request->direccion;
    $proveedore->telefono = $request->telefono;
    $proveedore->banco = $request->banco;
    $proveedore->cuenta = $request->cuenta;
    $proveedore->idtipo_proveedor = $request->idtipo_proveedor;
    $proveedore->razon_social = $request->razon_social;
    $proveedore->NombreContacto = $request->NombreContacto;
    $proveedore->TelefonoContacto = $request->TelefonoContacto;
    $proveedore->regimen_id = $request->regimen_id;
    $proveedore->cuenta_id = $request->cuenta_id;
    //$proveedore->estado = $request->estado;// <!-- agregue esto para el estado  valida el estado al actualizar el estado-->
    $proveedore->save();
    return redirect()->route('proveedores.index')
        ->with('success', 'Proveedor actualizado correctamente.');
}

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $proveedore = Proveedore::find($id)->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }

//     public function getProveedoresActivos() //<!-- agregue esto para el estado  esta funcion es para obtener los usuarios activos pero no sirve-->
// {
//     $proveedores = Proveedore::where('estado', 'activo')->get();
//     return $proveedores;
// }
}
