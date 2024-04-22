<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\cliente;

use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Document;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = cliente::with('persona')->latest()->get();
        return view('clientes.index', ['clientes'=>$clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $documentos = Documento::all();
        return view('clientes.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        try{
            DB::beginTransaction();
            //aca usamos el modelo caracteristica para crear una caracteristica con los campos que vienen del formulario atravez de la peticion
            //desde el formulario que hace una peticion a la funcion store de este controlador
            $persona = Persona::create($request->validated());
            $persona->cliente()->create([
                'persona_id' => $persona->id,
            ]);
            
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('clientes.index')->with('success', 'cliente registrado correctamente!');
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
    public function edit(cliente $cliente)
    {
        $cliente->load('persona.documento');
        $documentos = documento::all();
        return view('clientes.edit', compact('cliente', 'documentos'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, cliente $cliente)
    {
        Db::beginTransaction();
            Persona::where('id', $cliente->persona->id)
            ->update($request->validated());
        Db::commit();

        return redirect()->route('clientes.index')->with('success', 'cliente actualizado correctamente!');
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
            $mensaje = "cliente eliminado exitosamente";
        }else{
            Persona::where('id', $persona->id)
            ->update(['estado' => 1]);
            $mensaje = "cliente restaurado exitosamente";
        }
        

        return redirect()->route('clientes.index')->with('success',$mensaje);
    }
}
