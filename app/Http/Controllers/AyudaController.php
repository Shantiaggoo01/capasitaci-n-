<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    public function index()
    {
        return view('ayuda.index');
    }

    public function descargar($archivo)
{
    $pathToFile = storage_path('app/public/ayuda/'.$archivo);
    return response()->download($pathToFile);
}
}
