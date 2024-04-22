<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateProveedorRequest;
use App\Models\Proveedore;

use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Document;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('persona')->latest()->get();
        return view('proveedores.index', ['proveedores'=>$proveedores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $documentos = Documento::all();
        return view('proveedores.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        {
            DB::beginTransaction();
            //aca usamos el modelo caracteristica para crear una caracteristica con los campos que vienen del formulario atravez de la peticion
            //desde el formulario que hace una peticion a la funcion store de este controlador
            $persona = Persona::create($request->validated());
            $persona->proveedore()->create([
                'persona_id' => $persona->id,
            ]);
            
            DB::commit();
        }{
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success', 'proveedor registrado correctamente!');
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
    public function edit(Proveedore $proveedore)
    {
        $proveedore->load('persona.documento');
        $documentos = documento::all();
        return view('proveedores.edit', compact('proveedore', 'documentos'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedorRequest $request, Proveedore $proveedore)
    {
        Db::beginTransaction();
        Persona::where('id', $proveedore->persona->id)
            ->update($request->validated());
        Db::commit();

        return redirect()->route('proveedores.index')->with('success', 'proveedor actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mensaje = "";
        $persona = Persona::find($id);

        if($persona->estado==1){
            Persona::where('id', $persona->id)
            ->update(['estado' => 0]);
            $mensaje = "proveedor eliminado exitosamente";
        }else{
            Persona::where('id', $persona->id)
            ->update(['estado' => 1]);
            $mensaje = "proveedor restaurado exitosamente";
        }
        

        return redirect()->route('proveedores.index')->with('success',$mensaje);
    }
}
