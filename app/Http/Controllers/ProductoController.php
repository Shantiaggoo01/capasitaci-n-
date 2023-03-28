<?php

namespace App\Http\Controllers;

use App\Models\Detalle_produccion;
use App\Models\detalle_ventas;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Insumo;
use DB;
use App\Models\producto_insumo;


/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-producto|crear-producto|editar-producto|borrar-producto')->only('index');
        $this->middleware('permission:crear-producto' , ['only' => ['create','store']]);
        $this->middleware('permission:editar-producto' , ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-producto' , ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::paginate();

        return view('producto.index', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();

        $insumos = Insumo::all();

        return view('producto.create', compact('producto', 'insumos'));
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
            'nombre' => 'required|string|unique:productos',
            'tamaño' => 'required|string',
            'sabor' => 'required|string',
            'invima' => 'required|numeric',
            'peso' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'id_insumo' => 'required',
            'cantidades' => 'required',
        ]);
        //validar que un producto no tenga el mismo nombre
        
        $input = $request->all();
        try {
            DB::beginTransaction();
            $producto = Producto::create([
                "nombre" => $input["nombre"],
                "tamaño" => $input["tamaño"],
                "sabor" => $input["sabor"],
                "invima" => $input["invima"],
                "peso" => $input["peso"],
                "cantidad" => 0,
                "precio" => $input["Precio_producto"],
                //"Total" => $this->calcular_precio($input["id_insumo"], $input["cantidades"])

            ]);

            foreach($input["id_insumo"] as $key => $value){
                $producto_insumo = producto_insumo::create([
                    "id_insumo"=>$value,
                   /* "id_proveedor"=>$input["proveedor"][$key],*/
                    "id_producto"=>$producto->id,
                    "cantidad" => $input["cantidades"][$key],
                ]);
            }
            


            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
            

        } catch (Exception $e) {
            DB::rollback();

            return redirect("compra_insumos")->with('status',$e->getMessage());
        }

    }
    public function Calcular_precio($insumos, $cantidades)
    {

        $Total = 0;

        foreach ($insumos as $key => $value) {
        
            $insumo = Insumo::find($value);
            //capturo el valor del input cantidad
            $cantidad=

            $Total += ($insumo->Precio * $cantidades[$key]);
        }

        return $Total;
    }
    public function updateStatus($id)
{
    $provider = Producto::findOrFail($id);
    $producciones = Detalle_produccion::where('id_producto', $id)->first();
    if ($producciones) {
        return redirect()->route('productos.index')->with('error', 'No se puede desactivar el producto porque está asociado a una producción.');
    }
    $provider->update(['estado' => ! $provider->estado]);

    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //mostrar los insumos que tiene el producto seleccionado
        $producto = Producto::find($id);
        $insumos = DB::table('producto_insumo')
            ->join('insumos', 'producto_insumo.id_insumo', '=', 'insumos.id')
            ->select('insumos.*', 'producto_insumo.cantidad')
            ->where('producto_insumo.id_producto', '=', $id)
            ->get();


        return view('producto.show', compact('producto', 'insumos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idproducto)
    {
        $producto = Producto::find($idproducto);
    if (!$producto) {
        return redirect()->route('productos.index')->with('error', 'El producto no existe.');
    }
        $detalle = producto_insumo::where('id_producto',$idproducto)->get();
        $insumos = Insumo::all();
        return view('producto.edit', compact('producto','detalle','insumos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function detalle_eliminar($id){
        try {
            DB::beginTransaction();
            
            // Buscamos el detalle por el ID
            $detalle = producto_insumo::findOrFail($id);
            
            // Restablecemos la cantidad del insumo
            $insumo = Insumo::findOrFail($detalle->id_insumo);
            $insumo->cantidad += $detalle->cantidad;
            $insumo->save();
            
            // Eliminamos el detalle
            $detalle->delete();
    
            DB::commit();
            return redirect()->route('productos.edit', ['id' => $detalle->id_producto])->with('success', 'Detalle eliminado correctamente');
            
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('productos.edit', ['id' => $detalle->id_producto])->with('error', 'Error al eliminar detalle: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        //validacion de los campos
        $request->validate([
            'nombre' => 'required|string|unique:productos,nombre,' . $id,
            'tamaño' => 'required|string',
            'sabor' => 'required|string',
            'invima' => 'required|numeric',
            'peso' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'id_insumo' => 'required|array',
            'id_insumo.*' => 'required|numeric',
            'cantidades' => 'required|array',
            'cantidades.*' => 'required|numeric',
        ]);
    
        $input = $request->all();
    
        // Verificar que los arrays de "id_insumo" y "cantidades" tengan el mismo número de elementos
        if (count($input['id_insumo']) !== count($input['cantidades'])) {
            return redirect()->route('productos.index')->with('error', 'Los arrays de "id_insumo" y "cantidades" no tienen el mismo número de elementos.');
        }
    
        try {
            DB::beginTransaction();
    
            // Verificar que el producto con el id especificado exista en la base de datos antes de actualizarlo
            $producto = Producto::findOrFail($id);
    
            $producto->nombre = $input["nombre"];
            $producto->tamaño = $input["tamaño"];
            $producto->sabor = $input["sabor"];
            $producto->invima = $input["invima"];
            $producto->peso = $input["peso"];
            $producto->cantidad = $producto->cantidad;
            $producto->precio = $input["Precio_producto"];
            $producto->save();
    
            // actualizar registros en la tabla producto_insumo
            foreach($input["id_insumo"] as $key => $value){
                $producto_insumo = producto_insumo::where('id_producto', $id)->where('id_insumo', $value)->first();
    
                if($producto_insumo){
                    $producto_insumo->cantidad = $input["cantidades"][$key];
                    $producto_insumo->save();
                }
                else{
                    producto_insumo::create([
                        "id_insumo"=>$value,
                        "id_producto"=>$id,
                        "cantidad" => $input["cantidades"][$key],
                    ]);
                }
            }
    
            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.')->with('reload', 'true');
    
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            return redirect()->route('productos.index')->with('error', 'No se encontró el producto a actualizar.')->with('reload', 'true');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('productos.index')->with('error', 'Ha ocurrido un error al actualizar el producto: ' . $e->getMessage())->with('reload', 'true');
        }
    }
    

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
{
    try {
        DB::beginTransaction();
        
        // Buscamos el detalle por el ID
        $detalle = producto_insumo::findOrFail($id);
        
        // Restablecemos la cantidad del insumo
        $insumo = Insumo::findOrFail($detalle->id_insumo);
        $insumo->cantidad += $detalle->cantidad;
        $insumo->save();
        
        // Eliminamos el detalle
        $detalle->delete();

        DB::commit();
       
        
    } catch (Exception $e) {
        DB::rollback();
        
    }
}

}