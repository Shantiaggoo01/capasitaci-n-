<?php

namespace App\Http\Controllers;

use App\Models\TipoCliente;
use Illuminate\Http\Request;

/**
 * Class TipoClienteController
 * @package App\Http\Controllers
 */
class TipoClienteController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-tipocliente|crear-tipocliente|editar-tipocliente|borrar-tipocliente')->only('index');
        $this->middleware('permission:crear-tipocliente' , ['only' => ['create','store']]);
        $this->middleware('permission:editar-tipocliente' , ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-tipocliente' , ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoClientes = TipoCliente::paginate();

        return view('tipo-cliente.index', compact('tipoClientes'))
            ->with('i', (request()->input('page', 1) - 1) * $tipoClientes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoCliente = new TipoCliente();
        return view('tipo-cliente.create', compact('tipoCliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(TipoCliente::$rules);

        $tipoCliente = TipoCliente::create($request->all());

        return redirect()->route('tipo-clientes.index')
            ->with('success', 'TipoCliente created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoCliente = TipoCliente::find($id);

        return view('tipo-cliente.show', compact('tipoCliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoCliente = TipoCliente::find($id);

        return view('tipo-cliente.edit', compact('tipoCliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TipoCliente $tipoCliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoCliente $tipoCliente)
    {
        request()->validate(TipoCliente::$rules);

        $tipoCliente->update($request->all());

        return redirect()->route('tipo-clientes.index')
            ->with('success', 'TipoCliente updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tipoCliente = TipoCliente::find($id)->delete();

        return redirect()->route('tipo-clientes.index')
            ->with('success', 'TipoCliente deleted successfully');
    }
}
