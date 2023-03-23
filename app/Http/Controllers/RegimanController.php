<?php

namespace App\Http\Controllers;

use App\Models\Regiman;
use Illuminate\Http\Request;

/**
 * Class RegimanController
 * @package App\Http\Controllers
 */
class RegimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regimen = Regiman::paginate();

        return view('regiman.index', compact('regimen'))
            ->with('i', (request()->input('page', 1) - 1) * $regimen->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regiman = new Regiman();
        return view('regiman.create', compact('regiman'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Regiman::$rules);

        $regiman = Regiman::create($request->all());

        return redirect()->route('regimen.index')
            ->with('success', 'Regiman created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $regiman = Regiman::find($id);

        return view('regiman.show', compact('regiman'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiman = Regiman::find($id);

        return view('regiman.edit', compact('regiman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Regiman $regiman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regiman $regiman)
    {
        request()->validate(Regiman::$rules);

        $regiman->update($request->all());

        return redirect()->route('regimen.index')
            ->with('success', 'Regiman updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $regiman = Regiman::find($id)->delete();

        return redirect()->route('regimen.index')
            ->with('success', 'Regiman deleted successfully');
    }
}
