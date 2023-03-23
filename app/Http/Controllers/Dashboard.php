<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Compra;
use Carbon\Carbon;
use DB;
use Charts;



class Dashboard extends Controller
{
    public function index()
{
    $ventas = Venta::all();
    $cantidad = Venta::count();
    $total = Venta::sum('total');
    $productos = Producto::all();
    $cproducto = Producto::count();
    $produccion = Produccion::all();
    $cproduccion = Produccion::count();
    $ventas = Venta::where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('fecha')
                ->selectRaw('SUM(total) as total, DATE(created_at) as fecha')
                ->get();

                $productos = DB::table('ventas')
                ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.idVenta')
                ->join('productos', 'detalle_ventas.idProducto', '=', 'productos.id')
                ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as cantidad'))
                ->groupBy('productos.nombre')
                ->orderBy('cantidad', 'desc')
                ->take(5)
                ->get();
                $ventasA = DB::table('ventas')
                ->select(DB::raw('MONTH(FechaVenta) as mes, SUM(Total) as total_ventas'))
                ->whereYear('FechaVenta', date('Y'))
                ->groupBy('mes')
                ->get();

    // Obtenemos las compras del año actual
    $comprasA = DB::table('compras')
                ->select(DB::raw('MONTH(FechaCompra) as mes, SUM(Total) as total_compras'))
                ->whereYear('FechaCompra', date('Y'))
                ->groupBy('mes')
                ->get();
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                $clientes = DB::table('ventas')
                ->join('clientes', 'ventas.idCliente', '=', 'clientes.id')
                ->select('clientes.Nombre', DB::raw('SUM(Total) as TotalVentas'))
                ->groupBy('clientes.Nombre')
                ->orderBy('TotalVentas', 'desc')
                ->take(10)
                ->get();

    return view('dashboard', compact('ventas', 'cantidad', 'total', 'productos', 'cproducto', 'produccion', 'cproduccion', 'ventas', 'productos', 'comprasA', 'ventasA', 'meses', 'clientes'));
}

}
