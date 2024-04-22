<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\presentacione;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePresentacioneRequest;
use App\Http\Requests\UpdatePresentacioneRequest;
use App\Models\caracteristica;
use Exception;

class PresentacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones = presentacione::with('caracteristica')->latest()->get();
        return view('presentaciones.index', ['presentaciones'=>$presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacioneRequest $request)
    {
        try{
            DB::beginTransaction();
            //aca usamos el modelo caracteristica para crear una caracteristica con los campos que vienen del formulario atravez de la peticion
            //desde el formulario que hace una peticion a la funcion store de este controlador
            $caracteristica = caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('presentaciones.index')->with('success', 'presentacion registrada correctamente!');
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
    public function edit(presentacione $presentacione)
    {

        return view('presentaciones.edit', ['presentacione'=>$presentacione]);   
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacioneRequest $request, presentacione $presentacione)
    {
        caracteristica::where('id', $presentacione->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'presentacion editada Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = "";
        $presentacione = presentacione::find($id);

        if($presentacione->caracteristica->estado==1){
            caracteristica::where('id', $presentacione->caracteristica->id)
            ->update(['estado' => 0]);
            $mensaje = "Presentacion eliminada exitosamente";
        }else{
            caracteristica::where('id', $presentacione->caracteristica->id)
            ->update(['estado' => 1]);
            $mensaje = "Presentacion restaurada exitosamente";
        }
        

        return redirect()->route('presentaciones.index')->with('success',$mensaje);
    }
}
