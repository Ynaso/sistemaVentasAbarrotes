<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\Proveedore;
use App\Models\comprobante;
use App\Models\compra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompraRequest;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        $compras = compra::with('comprobante', 'Proveedore')
        ->where('estado', 1)
        ->latest()
        ->get();

        return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $proveedores = Proveedore::wherehas('persona', function($query){
        $query->where("estado", 1);
        })->get();
        $comprobantes = comprobante::all();
        $productos = producto::where('estado', 1)->get();
        return view('compras.create', compact('proveedores', 'comprobantes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {

       try{

        DB::beginTransaction();
        $compra = compra::create($request->validated());
       
        $arrayProducto_id = $request->get('arrayIdProducto');
        $arrayCantidad = $request->get('arrayCantidad');
        $arrayPrecioCompra = $request->get('arrayPrecioCompra');
        $arrayPrecioVenta = $request->get('arrayPrecioVenta');
    
        $sizeArray = count($arrayProducto_id);
        
        $cont = 0;

        while($cont < $sizeArray){
            $compra->productos()->syncWithoutDetaching([
                $arrayProducto_id[$cont]=>[
                    'cantidad' => $arrayCantidad[$cont],
                    'precio_compra' => $arrayPrecioCompra[$cont],
                    'precio_venta' => $arrayPrecioVenta[$cont]
                ]
            ]);

            $producto = Producto::find($arrayProducto_id[$cont]);
            $stockActual = $producto->stock;
            $stockNuevo = intval($arrayCantidad[$cont]);
            DB::table('productos')
            ->where('id', $producto->id)
            ->update(['stock'=>$stockActual + $stockNuevo]);
            $cont++;
        }
        DB::commit();
        
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('compras.index')->with('success', 'compra realizada correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(compra $compra)
    {
        return view('compras.show', compact('compra'));
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
        $mensaje = "";
        $compra = compra::find($id);
        $id_productos = [];
        $cantidad = [];
        //al usar la relacion productos() que esta en el modelo de compras, obtenemos acceso a todos los productos basandonos en el id de compra de la tabla pivoteo
        $compra_producto = $compra->productos()->wherePivot('compra_id', $id)->get();
        $cuenta = 0;
        
        foreach ($compra_producto as $producto_compra) {
            //esta linea nada mas accede a la tabla de productos (que es la tabla final de los productos, ya que el arreglo que devuelve son los productos)
            $producto = Producto::find($producto_compra->id);
            $stockActual = $producto->stock;
            //pero para restar la cantidad, tenemos que acceder a esos productos comprados en la tabla pivoteo con pivot, y deberia funcionar, esto nos traera las cantidades compradas
            $stockRevertido = $producto_compra->pivot->cantidad;
            DB::table('productos')
            ->where('id', $producto->id)
            //y aca restamos esta anulacion de compras y listo
            ->update(['stock'=>$stockActual - $stockRevertido]);
        }
        
        compra::where('id', $compra->id)
        ->update(['estado' => 0]);
        $mensaje = "compra Anulada exitosamente";

        return redirect()->route('compras.index')->with('success',$mensaje);
    }
}
