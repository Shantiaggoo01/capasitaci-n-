<?php

namespace App\Http\Controllers;

use App\Models\CompraInsumo;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Proveedore;
use DB;
use Exception;

/**
 * Class CompraInsumoController
 * @package App\Http\Controllers
 */
class CompraInsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-compras')->only('index');
    }

    public function index(Request $request)
{
    $compraInsumos = CompraInsumo::paginate();

    $compras = Compra::select("compras.*", "proveedores.nombre as nombreProveedor")
        ->join("proveedores", "proveedores.id", "=", "compras.id_proveedor")
        ->get();

    $insumos = Insumo::all();
    $proveedores = Proveedore::all();

    $fecha = $request->input('fecha');
    if ($fecha) {
        $fecha = date('Y-m-d', strtotime($fecha));
        $compras = Compra::select("compras.*", "proveedores.nombre as nombreProveedor")
            ->join("proveedores", "proveedores.id", "=", "compras.id_proveedor")
            ->whereDate('FechaCompra', $fecha)
            ->get();
        $totalComprasFecha = Compra::whereDate('FechaCompra', $fecha)->sum('Total');
    } else {
        $totalComprasFecha = 0;
    }

    return view('compra_insumos.index', compact('compraInsumos', 'compras', 'insumos', 'proveedores', 'totalComprasFecha'))
        ->with('i', (request()->input('page', 1) - 1) * $compraInsumos->perPage());
}
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compraInsumo = new CompraInsumo();
        $compras = Compra::all();
        //$insumos = Insumo::all();
        $proveedores = Proveedore::where('estado', '1')->get(); //<!-- agregue esto para el estado  la consulta para el select , que solo muestre los que estan con l a palabra activos-->
        $insumos = Insumo::where('estado', '1')->get();//<!-- agregue esto para el estado  la consulta para el select , que solo muestre los que estan con l a palabra activos-->
        return view('compra_insumos.create', compact('compraInsumo', 'compras', 'insumos', 'proveedores'));
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
    
        $this->validate($request, [
            'nFactura' => 'required|unique:compras',
            'id_proveedor' => 'required',
            'id_insumo' => 'required',
            'FechaCompra' => 'required|date|before_or_equal:today',
        ], [
            'nFactura.required' => 'El campo Número de Factura es obligatorio.',
            'nFactura.unique' => 'El Número de Factura ya existe.',
        ]);
    
        try {
            // Obtenemos el usuario actual autenticado <--- agregue esto para guardar el usuario que creo la compra 
            $user = auth()->user();
            
            // Iniciamos una transacción de base de datos
            DB::beginTransaction();
    
            // Creamos la compra y asociamos al usuario que la creó
            $compra = Compra::create([
                "nFactura" => $input["nFactura"],
                "id_proveedor" => $input["id_proveedor"],
                "id_insumo" => $input["id_insumos"],
                "FechaCompra" => $input["FechaCompra"],
                "Total" => $this->calcular_precio($input["id_insumo"], $input["cantidades"]),
                "user_id" => $user->id // Agregamos el usuario que realizó la compra <--- agregue esto para guardar el usuario que creo la compra 
            ]);
    
            foreach ($input["id_insumo"] as $key => $value) {
                CompraInsumo::create([
                    "id_insumo" => $value,
                    "id_compra" => $compra->id,
                    "cantidad" => $input["cantidades"][$key],
                ]);
    
                $ins = Insumo::find($value);
                $ins->update(["cantidad" => $ins->cantidad + $input["cantidades"][$key]]);
                $ins->update(["cantidadxMedida" => $ins->Medida * $input["cantidades"][$key]]);
            }
    
            // Confirmamos la transacción
            DB::commit();
            return redirect("compra_insumos")->with('success', 'Compra realizada con éxito');
        } catch (Exception $e) {
            // Si ocurre un error, hacemos un rollback de la transacción
            DB::rollback();
            return redirect("compra_insumos")->with('status', $e->getMessage());
        }
    }

    public function Calcular_precio($insumos, $cantidades)
    {

        $Total = 0;

        foreach ($insumos as $key => $value) {

            $insumo = Insumo::find($value);
            $Total += ($insumo->Precio * $cantidades[$key]);
        }

        return $Total;
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {


        $id = $request->input("id");
        $insumos = [];
        if ($id != null) {
            $insumos = Insumo::select("insumos.*", "compra_insumos.cantidad")
                ->join("compra_insumos", "insumos.id", "=", "compra_insumos.id_insumo")
                ->where("compra_insumos.id_compra", $id)
                ->get();
        }
        $compras = [];
        if ($id != null) {
            $compras = Compra::select("compras.*")
                ->join("compra_insumos", "compras.id", "=", "compra_insumos.id_compra")
                ->where("compra_insumos.id_compra", $id)
                ->get();
        }

        $compra = Compra::with('user')->find($id); //<--- agregue esto para guardar el usuario que creo la compra 


        return view("compra_insumos.show", compact("insumos", "compras","compra"));
    }
}
