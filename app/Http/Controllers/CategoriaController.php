<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\caracteristica;
use App\Models\categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $categorias = categoria::with('caracteristica')->latest()->get();
        return view('categorias.index', ['categorias'=>$categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
       
        try{
            DB::beginTransaction();
            $caracteristica = caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success', 'categoria registrada correctamente!');
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
    public function edit(categoria $categoria)
    {
     return view('categorias.edit', ['categoria'=>$categoria]);   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, categoria $categoria)
    {
        caracteristica::where('id', $categoria->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('categorias.index')->with('success', 'categoria editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   $mensaje = "";
        $categoria = categoria::find($id);

        if($categoria->caracteristica->estado==1){
            caracteristica::where('id', $categoria->caracteristica->id)
            ->update(['estado' => 0]);
            $mensaje = "categoria eliminada exitosamente";
        }else{
            caracteristica::where('id', $categoria->caracteristica->id)
            ->update(['estado' => 1]);
            $mensaje = "categoria restaurada exitosamente";
        }
        

        return redirect()->route('categorias.index')->with('success',$mensaje);
    }
}
