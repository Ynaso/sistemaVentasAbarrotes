@extends('template')


@section('title'. 'crear cliente')

@push('css')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endpush

@section('content')

<div class="container-fluid px-4">
    
    <h1 class="mt-4 text-center">clientes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('clientes.index')}}" class="href">clientes</a></li>
        <li class="breadcrumb-item active">Crear clientes</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('proveedores.update', ['proveedore'=>$proveedore])}}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6 ">
                    <label for="tipo_persona" class="form-label">tipo de cliente:</label>
                    <select data-size="5" title="Selecciona el tipo de persona" data-live-search="true" name="tipo_persona" id="tipo_persona" class="form-control selectpicker show-tick">
                        <option selected value="{{$proveedore->persona->tipo_persona}}">{{"Proveedor ".$proveedore->persona->tipo_persona}}</option> 
                    </select>
                   
                </div>

                <div class="col-md-12" id="box-razon_social">
                    
                <label id="label_natural" class="form-label">Razon social o Nombre del Proveedor</label>
        
                   <input tipe="text" name="razon_social" id="razon_social" class="form-control" value="{{old('direccion', $proveedore->persona->razon_social)}}"/>
                   @error('razon_social')
                        <small class="text-danger">{{'*'.$message}}</small>
                   @enderror 
                </div>

                            
                <div class="col-md-12 ">
                    <label for="direccion" class="form-label">direccion:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion', $proveedore->persona->direccion)}}" />
                    @error('direccion')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror
                </div>


                <div class="col-md-6">
                    <label for="documento_id" class="form-label">tipo de documento:</label>
                    <select data-size="5" title="Selecciona el tipo de persona" data-live-search="true" name="documento_id" id="documento_id" class="form-control selectpicker show-tick">
                        <option value="" selected disabled>selecciona una opcion</option>
                        @foreach($documentos as $documento)
                           
                            @if ($proveedore->persona->documento_id == $documento->id)
                                <option selected value="{{$documento->id}}"  {{old('documento_id')== $documento->id?:''}}>{{$documento->tipo_documento}}</option>
                            @else
                                <option value="{{$documento->id}}"  {{old('documento_id')== $documento->id?:''}}>{{$documento->tipo_documento}}</option>
                            @endif
                        
                        @endforeach
                    </select>
                     @error('documento_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

    
                <div class="col-md-6 ">
                    <label for="numero_documento" class="form-label">numero de documento:</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{old('numero_documento', $proveedore->persona->numero_documento)}}" />
                    @error('numero_documento')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>


                     


                
                <div class="col-md-12 text-center ">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')


@endpush