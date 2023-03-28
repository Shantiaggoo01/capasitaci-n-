<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Producto;
use Illuminate\Http\Request;
use DB;
use App\Models\Detalle_produccion;
use App\Models\Insumo;
use App\Models\producto_insumo;
use Illuminate\Support\Facades\Log;

/**
 * Class ProduccionController
 * @package App\Http\Controllers
 */
class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produccions = Produccion::paginate();
        $productos = Producto::where('cantidad', '<', 25)->get();

        return view('produccion.index', compact('produccions', 'productos'))
            ->with('i', (request()->input('page', 1) - 1) * $produccions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produccion = new Produccion();
        $productos = Producto::where('estado', '1')->get();
        return view('produccion.create', compact('produccion', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         $input = $request->all();
         //validaciones
            $request->validate([
                'FechaP' => 'required|date',
                'FechaV' => 'required|date',
                'producto' => 'required',
                'cantidad' => 'required',
            ]);
            $detalles = $request->input('detalles');
         try {
            Log::debug('Creando nueva producción');
             DB::beginTransaction();
             
             $produccion = Produccion::create([
                 'fecha_producción' => $input['FechaP'],
                 'fecha_vencimiento' => $input['FechaV'],
                 'cantidad' => $input['cantidad'],
             ]);
             
             // Verificar si el producto es una matriz y luego recorrerla
             if (is_array($input['producto_id'])) {
                 foreach ($input['producto_id'] as $key => $value) {
                     $detalle_produccion = Detalle_produccion::create([
                         'id_produccion' => $produccion->id,
                         'id_producto' => $value,
                         'cantidad' => $input['cantidades'][$key],
                     ]);
                     $ins = Producto::find($value);
                     $ins->update(['cantidad' => $ins->cantidad + $input['cantidades'][$key]]);
                      try {
                       if(is_array($input['producto_id'])){
                             foreach ($input['producto_id'] as $key => $value) {
                                 $produccion = Detalle_produccion::where('id_produccion', $produccion->id)->first();
                               $producto = Producto::where('id', $produccion->id_producto)->first();
                               $producto_insumo = producto_insumo::where('id_producto', $producto->id)->get();
                                $insumos_restantes = 0;
                                 foreach ($producto_insumo as $producto_insumo) {
                                     $insumo = Insumo::where('id', $producto_insumo->id_insumo)->first();
                                     if($insumo && $insumo->Nombre =='aceite'){
                                        $total = intval($input['cantidades'][$key] / 150);
                                        $insumo->cantidadxMedida -= $total * 20000;
                                        
                                            $insumo->cantidad -= $total;
                                        
                                            
                                            $insumo->save();
                                     }
                                     if($insumo && $insumo->Nombre =='sal'){
                                        $total = intval($input['cantidades'][$key] / 150);
                                        $insumo->cantidadxMedida -= $total * 5000;
                                        
                                            $insumo->cantidad -= $total;
                                        
                                            
                                            $insumo->save();
                                     }

                                     if($insumo && $insumo->Nombre =='sal limon'){
                                        $total = intval($input['cantidades'][$key] / 150);
                                        $insumo->cantidadxMedida -= $total * 5000;
                                        
                                            $insumo->cantidad -= $total;
                                        
                                            
                                            $insumo->save();
                                     }

                                     if($insumo && $insumo->Nombre =='sal pimienta'){
                                        $total = intval($input['cantidades'][$key] / 150);
                                        $insumo->cantidadxMedida -= $total * 5000;
                                        
                                            $insumo->cantidad -= $total;
                                        
                                            
                                            $insumo->save();
                                     }

                                     if($insumo && $insumo->Nombre =='sal bbq'){
                                        $total = intval($input['cantidades'][$key] / 150);
                                        $insumo->cantidadxMedida -= $total * 5000;
                                        
                                            $insumo->cantidad -= $total;
                                        
                                            
                                            $insumo->save();
                                     }

                                     if($insumo && $insumo->Nombre =='sal natural'){
                                        $total = intval($input['cantidades'][$key] / 150);
                                        $insumo->cantidadxMedida -= $total * 5000;
                                        
                                            $insumo->cantidad -= $total;
                                        
                                            
                                            $insumo->save();
                                     }


                                     if ($insumo && $insumo->Nombre == 'papas') {
                                        if ($input['cantidades'][$key] > 150) {
                                            $total = intval($input['cantidades'][$key] / 150);
                                            $insumo->cantidadxMedida -= $total * 50000;
                                            $insumo->cantidad -= $total;
                                    
                                            // Restar 1 si la cantidad de medida es un múltiplo de 150
                                            
                                        } else {
                                            $insumo->cantidadxMedida -= 50000;
                                            $insumo->cantidad -= 1;
                                        }
                                    
                                        $insumo->save();
                                    }
                                    
                                    
                                    
                                     $count = 0;


                               }
                                 
                             }
                        }
                    } catch (\Exception $e) {
                         return redirect()->route('produccion.index')->with('error', 'No hay suficientes insumos para producir este producto')->with('reload', 'true');
                 }
                 }
                 
             } 
             $ins->save();
             
             DB::commit();
             Log::debug('Producción creada correctamente');
             return redirect()->route('produccion.index')->with('success', 'Producción creada con éxito.')->with('reload', 'true');
             
         } catch (\Exception $e) {
             DB::rollback();
             Log::error($e->getMessage());
             return redirect()->route('produccion.index')->with('error', 'Error al crear la producción.')->with('reload', 'true');
         }
     }
     


    
            
    
            
            
    public function Calcular_precio($insumos, $cantidades)
    {

        $Total = 0;

        foreach ($insumos as $key => $value) {
        
            $producto = Producto::find($value);
            //capturo el valor del input cantidad
            $cantidad=

            $Total += ($producto->Precio * $cantidades[$key]);
        }

        return $Total;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $produccion = Produccion::find($id);
    $detalles = DB::table('produccion')
        ->select('produccion.*', 'detalle_produccion.id_producto', 'detalle_produccion.cantidad', 'productos.*')
        ->join('detalle_produccion', 'produccion.id', '=', 'detalle_produccion.id_produccion')
        ->join('productos', 'detalle_produccion.id_producto', '=', 'productos.id')
        ->where('produccion.id', '=', $id)
        ->get();
    
    return view('produccion.show', compact('produccion', 'detalles'));
}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produccion = Produccion::find($id);

        return view('produccion.edit', compact('produccion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Produccion $produccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produccion $produccion)
    {
        request()->validate(Produccion::$rules);

        $produccion->update($request->all());

        return redirect()->route('produccions.index')
            ->with('success', 'Produccion updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $produccion = Produccion::find($id)->delete();

        return redirect()->route('produccions.index')
            ->with('success', 'Produccion deleted successfully');
    }
}