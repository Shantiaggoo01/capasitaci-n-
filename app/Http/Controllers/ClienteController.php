<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoCliente;

use Illuminate\Http\Request;

/**
 * Class ClienteController
 * @package App\Http\Controllers
 */
class ClienteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|borrar-cliente')->only('index');
        $this->middleware('permission:crear-cliente' , ['only' => ['create','store']]);
        $this->middleware('permission:editar-cliente' , ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-cliente' , ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::paginate();
        $tipos = TipoCliente::pluck('Nombre','id');

        return view('cliente.index', compact('clientes','tipos'))
       

       
            ->with('i', (request()->input('page', 1) - 1) * $clientes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = new Cliente();
        $tipos = TipoCliente::pluck('Nombre','id');
        return view('cliente.create', compact('cliente','tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'NIT' => 'required|numeric|min:10|unique:clientes',
            'Nombre' => ['required', 'regex:/^[\pL\s]+$/u'],
            'Apellido' => ['required', 'regex:/^[\pL\s]+$/u'],
            'idTipoCliente' => 'required',
            'Telefono' => 'required|numeric',
            'Direccion' => 'required',
            
        ]);
        request()->validate(Cliente::$rules);

        $cliente = Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }
    public function updateStatus($id)
    {
        $provider = Cliente::findOrFail($id);
        $provider->update(['Estado' => ! $provider->Estado]);
    
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);
        $tipos = TipoCliente::pluck('Nombre','id');

        return view('cliente.edit', compact('cliente','tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        request()->validate(Cliente::$rules);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id)->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente borrado correctamente');
    }
}
