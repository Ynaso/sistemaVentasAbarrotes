@extends('template')


@section('title'. 'crear cliente')

@push('css')

<style>
    #box-razon_social{
        display: none;
    }
</style>

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
    <div class="mb-4">
        <a href="{{route('clientes.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo Cliente</button></a>
    </div>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('clientes.store')}}" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-md-6 ">
                    <label for="tipo_persona" class="form-label">tipo de cliente:</label>
                    <select data-size="5" title="Selecciona el tipo de persona" data-live-search="true" name="tipo_persona" id="tipo_persona" class="form-control selectpicker show-tick">
                        <option value="" selected disabled>selecciona una opcion</option>
                        <option value="natural" {{old('tipo_persona')== 'natural'?'selected':''}}>Persona Natural</option>
                        <option value="juridica" {{old('tipo_persona')== 'juridica'?'selected':''}}>Persona Juridica</option>
                    </select>
                     @error('tipo_persona')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                <div class="col-md-12" id="box-razon_social">
                   <label id="label_natural" class="form-label">Nombres y Apellidos</label>
                   <label id="label_juridica" class="form-label">Nombre de la Empresa</label>
                   <input tipe="text" name="razon_social" id="razon_social" class="form-control"></input>
                   
                   @error('razon_social')
                        <small class="text-danger">{{'*'.$message}}</small>
                   @enderror 

                </div>

                            
                <div class="col-md-12 ">
                    <label for="direccion" class="form-label">direccion:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion')}}" />
                    @error('direccion')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror
                </div>


                <div class="col-md-6 ">
                    <label for="documento_id" class="form-label">tipo de documento:</label>
                    <select data-size="5" title="Selecciona el tipo de persona" data-live-search="true" name="documento_id" id="documento_id" class="form-control selectpicker show-tick">
                        <option value="" selected disabled>selecciona una opcion</option>
                        @foreach($documentos as $documento)
                            <option value="{{$documento->id}}"  {{old('documento_id')== $documento->id?:''}}>{{$documento->tipo_documento}}</option>
                        @endforeach
                    </select>
                     @error('documento_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

    
                <div class="col-md-6 ">
                    <label for="numero_documento" class="form-label">numero de documento:</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{old('numero_documento')}}" />
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
<script>
    
   $(document).ready(function(){
        $('#tipo_persona').on('change', function(){
            let SelectValue = $(this).val();

            if(SelectValue == 'natural'){
                $('#label_juridica').hide();
                $('#label_natural').show();
            }else{
                $('#label_natural').hide();
                $('#label_juridica').show();
            }

            $('#box-razon_social').show();
        });
    });
</script>

@endpush