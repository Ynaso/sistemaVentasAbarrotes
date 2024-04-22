@extends('template')


@section('title'. 'crear categoria')

@push('css')
    <style>
        #descripcion{
            resize: none;
        }
    </style>
@endpush

@section('content')

<div class="container-fluid px-4">
    
    <h1 class="mt-4 text-center">Editar Marca</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('marcas.index')}}" class="href">Marcas</a></li>
        <li class="breadcrumb-item active">editar Marcas</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('marcas.update',  ['marca'=>$marca])}}"><button type="button" class="btn btn-primary">Añadir nueva Marca</button></a>
    </div>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('marcas.update', ['marca'=>$marca])}}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6 ">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('descripcion', $marca->caracteristica->nombre)}}">
                     @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                <div class="col-md-12 ">
                    <label for="descripcion" class="form-label">descripcion:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{old('descripcion', $marca->caracteristica->descripcion)}}</textarea>
                    @error('descripcion')
                        <small>{{$message}}</small>
                    @enderror   
                </div>

                <div class="col-md-12 text-center ">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="reset" class="btn btn-secondary">reiniciar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush