<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\marca;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\caracteristica;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = marca::with('caracteristica')->latest()->get();
        return view('marcas.index', ['marcas'=>$marcas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request)
    {
        try{
            DB::beginTransaction();
            $caracteristica = caracteristica::create($request->validated());
            $caracteristica->marca()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('marcas.index')->with('success', 'marca registrada correctamente!');
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
    public function edit(marca $marca)
    {
        return view('marcas.edit', ['marca'=>$marca]);   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, marca $marca)
    {
       
        caracteristica::where('id', $marca->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('marcas.index')->with('success', 'marca editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = "";
        $marca = marca::find($id);

        if($marca->caracteristica->estado==1){
            caracteristica::where('id', $marca->caracteristica->id)
            ->update(['estado' => 0]);
            $mensaje = "Marca eliminada exitosamente";
        }else{
            caracteristica::where('id', $marca->caracteristica->id)
            ->update(['estado' => 1]);
            $mensaje = "Marca restaurada exitosamente";
        }
        

        return redirect()->route('marcas.index')->with('success',$mensaje);
    }
}
