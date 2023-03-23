<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;

/**
 * Class InsumoController
 * @package App\Http\Controllers
 */
class InsumoController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-insumos|crear-insumos|editar-insumos|borrar-insumos|Ver-Menu-Configuracion|Ver-Menu-Compras|Ver-Menu-Produccion|ver-Menu-Reportes|Ver-Menu-Ventas')->only('index');
        $this->middleware('permission:crear-insumos' , ['only' => ['create','store']]);
        $this->middleware('permission:editar-insumos' , ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-insumos' , ['only' => ['destroy']]);
    }
    /*
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insumos = Insumo::paginate();
        

        return view('insumo.index', compact('insumos'))
            ->with('i', (request()->input('page', 1) - 1) * $insumos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $insumo = new Insumo();
        return view('insumo.create', compact('insumo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            'Nombre' => ['required', 'regex:/^[\pL\s]+$/u'],
            'TipoCantidad' => 'required|string',
            'Precio' => 'required|numeric',
            'Medida' => 'required|numeric',
        ]);
        request()->validate(Insumo::$rules);

        $insumo = Insumo::create($request->all());

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo creado correctamente');
    }
    public function updateStatus($id)
    {
        $provider = Insumo::findOrFail($id);
        $provider->update(['Estado' => ! $provider->Estado]);
    
        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insumo = Insumo::find($id);

        return view('insumo.show', compact('insumo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insumo = Insumo::find($id);
        return view('insumo.edit', compact('insumo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Insumo $insumo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insumo $insumo)
    {
        request()->validate(Insumo::$rules);

        $insumo->update($request->all());

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $insumo = Insumo::find($id)->delete();

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo borrado correctamente');
    }

   
}
