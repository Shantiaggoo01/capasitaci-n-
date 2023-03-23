<?php

namespace App\Http\Controllers;

use App\Models\Tiposcuenta;
use Illuminate\Http\Request;

/**
 * Class TiposcuentaController
 * @package App\Http\Controllers
 */
class TiposcuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposcuentas = Tiposcuenta::paginate();

        return view('tiposcuenta.index', compact('tiposcuentas'))
            ->with('i', (request()->input('page', 1) - 1) * $tiposcuentas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiposcuenta = new Tiposcuenta();
        return view('tiposcuenta.create', compact('tiposcuenta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Tiposcuenta::$rules);

        $tiposcuenta = Tiposcuenta::create($request->all());

        return redirect()->route('tiposcuentas.index')
            ->with('success', 'Tiposcuenta created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tiposcuenta = Tiposcuenta::find($id);

        return view('tiposcuenta.show', compact('tiposcuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tiposcuenta = Tiposcuenta::find($id);

        return view('tiposcuenta.edit', compact('tiposcuenta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tiposcuenta $tiposcuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tiposcuenta $tiposcuenta)
    {
        request()->validate(Tiposcuenta::$rules);

        $tiposcuenta->update($request->all());

        return redirect()->route('tiposcuentas.index')
            ->with('success', 'Tiposcuenta updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tiposcuenta = Tiposcuenta::find($id)->delete();

        return redirect()->route('tiposcuentas.index')
            ->with('success', 'Tiposcuenta deleted successfully');
    }
}
