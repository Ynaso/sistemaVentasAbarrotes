<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\comprobante;
use App\Models\ventas;
use App\Http\Requests\StoreVentaRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\producto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {  

       $clientes = cliente::wherehas('persona', function($query){
            $query->where('estado', 1);
        })->get(); 

     

        
        //esta sub consulta nos traera los ultimos productos ingresados en nuestra tabla pivoteo compra_producto, para que podamos usar la sub consulta en un where
        //y que funcione asi como un criterio
        $subquery = DB::table('compra_producto')
        ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
        ->groupBy('producto_id');
    
    
    /* $productos = producto::join('compra_producto as cpr', function($join) use($subquery){
            $join->on('cpr.producto_id', '=', 'productos.id')
            ->whereIn('cpr.created_at', 
            function($query) use($subquery)
            {
                //justo esta parte nos prmite seleccionar la columna max_created at que creamos desde el DB:RAW arriba, para obtener los ultimos precios
                //añadidos a nuestro inventario(desde la subquery)
                $query->select('max_created_at')
                ->fromSub($subquery, 'subquery')
                //y esta parte filtra la tabla cpr, de los ultimos valores ingresados en el compra producto, hacia la tabla en general
                ->whereRaw('subquery.producto_id = cpr.producto_id');
            }
        );
            
        });*/

       

        $productos = DB::Table('productos')
        ->join('compra_producto', 'productos.id', '=', 'compra_producto.producto_id')
        ->whereIn('compra_producto.created_at', $subquery->pluck('max_created_at'))
        ->select('productos.nombre', 'productos.id', 'productos.stock', 'compra_producto.precio_venta', 'productos.codigo')
        ->where('productos.estado', 1)
        ->where('productos.stock','>', 0)
        ->get();

        $comprobantes = comprobante::all();
        return view('ventas.create', compact('productos', 'clientes', 'comprobantes'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
       
        
        $venta = ventas::create($request->validated());
        $arrayProducto_id = $request->get('arrayIdProducto');
        $arrayCantidad = $request->get('arrayCantidad');
        $arrayDescuento = $request->get('arrayDescuento');
        $arrayPrecioVenta = $request->get('arrayPrecioVenta');
    
        $sizeArray = count($arrayProducto_id);
        
        $cont = 0;

       
        while($cont < $sizeArray){
            $venta->productos()->syncWithoutDetaching([
                //esta linea fue un workaround, por que estabamaos pasando id, precio y cantidad en el request,
                //entonces hice esto nada mas para obtener el ID del producto
                explode("-", $arrayProducto_id[0])[0]=>[
                    'cantidad' => $arrayCantidad[$cont],
                    'descuento' => $arrayDescuento[$cont],
                    'precio_venta' => $arrayPrecioVenta[$cont]
                ]
            ]);

            $producto = Producto::find($arrayProducto_id[$cont]);
            $stockActual = $producto->stock;
            $stockNuevo = intval($arrayCantidad[$cont]);
            DB::table('productos')
            ->where('id', $producto->id)
            ->update(['stock'=>$stockActual - $stockNuevo]);
            $cont++;
            DB::commit();

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
