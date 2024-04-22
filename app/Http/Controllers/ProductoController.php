<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\categoria;
use App\Models\producto;
use App\Models\marca;
use App\Models\presentacione;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //este codigo se encarga de inyectar hacia la vista indice, la variable productos(obtenidos desde la base de datos usando el ORM), que despues
        //renderizamos en la vista usando codigo PHP, gracias
        $productos = producto::with(['categorias.caracteristica', 'marca.caracteristica', 'presentacione.caracteristica'])->latest()->get();
        return view('productos.index', compact('productos'));

      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
        ->select('marcas.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();
        
        $presentaciones = presentacione::join('caracteristicas as c', 'presentaciones.caracteristica_id', '=', 'c.id')
        ->select('presentaciones.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();

        $categorias = categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
        ->select('categorias.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();
        
       return view('productos.create', compact('marcas', 'presentaciones', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        try{
            DB::beginTransaction();
            $producto = new producto();

            if($request->hasFile('img_path')){
                //este elemento img_path viene desde la peticion hecha en el formulario de creacion de producto
               $name = $producto->handleUploadImage($request->file('img_path'));
            }else{
                $name = null;
            }

            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacione_id' => $request->presentacione_id,

            ]);

            $producto->save();

            //tabla Categoria_producto (esta es necesaria para saber todas las categorias por productos)
            $categorias = $request->get('categorias');
            $producto->categorias()->attach($categorias);

            DB::commit();
          
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'producto creado exitosamente ;)');
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
    public function edit(producto $producto)
    {
        $marcas = marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
        ->select('marcas.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();
        
        $presentaciones = presentacione::join('caracteristicas as c', 'presentaciones.caracteristica_id', '=', 'c.id')
        ->select('presentaciones.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();

        $categorias = categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
        ->select('categorias.id as id', 'c.nombre as nombre')
        ->where('c.estado', 1)
        ->get();
        

        return view("productos.edit", compact('producto', 'marcas', 'presentaciones', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request,producto $producto)
    {
        try{
            DB::beginTransaction();
         
            if($request->hasFile('img_path')){
                //este elemento img_path viene desde la peticion hecha en el formulario de creacion de producto
               $name = $producto->handleUploadImage($request->file('img_path'));
             if(Storage::disk('public')->exists('productos/'.$producto->img_path)){
                Storage::disk('public')->delete('productos/'.$producto->img_path);
             }  
            }else{
                $name = $producto->img_path;
            }

            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacione_id' => $request->presentacione_id,

            ]);

            $producto->save();

            //tabla Categoria_producto (esta es necesaria para saber todas las categorias por productos)
            $categorias = $request->get('categorias');
            $producto->categorias()->sync($categorias);

            DB::commit();
          
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'producto actualizado exitosamente ;)');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = "";
        $producto = producto::find($id);

        if($producto->estado==1){
            producto::where('id', $producto->id)
            ->update(['estado' => 0]);
            $mensaje = "producto eliminado exitosamente";
        }else{
            producto::where('id', $producto->id)
            ->update(['estado' => 1]);
            $mensaje = "producto restaurada exitosamente";
        }
        

        return redirect()->route('productos.index')->with('success',$mensaje);
    }
}
