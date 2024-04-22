@extends('template')


@section('title'. 'crear categoria')

@push('css')
    <style>
        #descripcion{
            resize: none;
        }
    </style>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js">
    
</script>

@endpush

@section('content')

<div class="container-fluid px-4">
    
    <h1 class="mt-4 text-center">Crear Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('productos.index')}}" class="href">Productos</a></li>
        <li class="breadcrumb-item active">Crear Producto</li>
    </ol>


    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('productos.update', ['producto'=>$producto])}}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
          
            <div class="row g-3">
                <div class="col-md-6 ">
                    <label for="codigo" class="form-label">codigo:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo', $producto->codigo)}}">
                     @error('codigo')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                <div class="col-md-6 ">
                    <label for="nombre" class="form-label">nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $producto->nombre)}}">
                     @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>
                
                <div class="col-md-12 ">
                    <label for="descripcion" class="form-label">descripcion:</label>
                    <textarea name="descripcion" id="descripcion" class="form-control"  rows="4">{{old('descripcion', $producto->descripcion)}}</textarea>
                    @error('descripcion')
                        <small>{{$message}}</small>
                    @enderror   
                </div>
                
                <div class="col-md-6 ">
                    <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value = {{old('fecha_vencimiento', $producto->fecha_vencimiento)}}>
                     @error('fecha_vencimiento')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                
                <div class="col-md-6 ">
                    <label for="img_path" class="form-label">Imagen:</label>
                    <input type="file" name="img_path" id="img_path" class="form-control" value = {{old('img_path')}} accept="image/*">
                     @error('img_path')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                <div class="col-md-6 mb-2 ">
                    <label for="marca_id" class="form-label">Marca:</label>
                    <select data-size="5" title="Selecciona una marca" data-live-search="true" name="marca_id" id="marca_id" class="form-control selectpicker show-tick">
                        @foreach($marcas as $item)
                            @if ($producto->marca_id == $item->id)
                                <option selected value="{{$item->id}}" {{old('marca_id')== $item->id?'selected':''}}>{{$item->nombre}}</option>        
                            @else
                                <option selected value="{{$item->id}}" {{old('marca_id')== $item->id?'selected':''}}>{{$item->nombre}}</option> 
                            @endif
                        @endforeach
                    </select>
                     @error('marca_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                <div class="col-md-6 mb-2">
                    <label for="presentacione_id" class="form-label">Presentacion:</label>
                    <select data-size="5" title="Selecciona una presentacion" data-live-search="true" name="presentacione_id" id="presentacione_id" class="form-control selectpicker show-tick" >
                        @foreach($presentaciones as $item)
                            @if ($producto->presentacione_id == $item->id)
                                <option selected value="{{$item->id}}" {{old('presentacione_id')== $item->id?'selected':''}}>{{$item->nombre}}</option>
                            @else
                                <option value="{{$item->id}}" {{old('presentacione_id')== $item->id?'selected':''}}>{{$item->nombre}}</option>    
                            @endif
                           
                        @endforeach
                    </select>
                     @error('presentacione_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                     @enderror   
                </div>

                <div class="col-md-6 mb-2">
                    <label for="categorias" class="form-label">Categorias:</label>
                    <select data-size="5" title="Selecciona las categorias de su producto" data-live-search="true" name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                        @foreach($categorias as $item)
                        @if (in_array($item->id, $producto->categorias->pluck('id')->toArray()))
                            <option selected value="{{$item->id}}"  {{(in_array($item->id, old('categorias', [])))?'selected': ''}}>{{$item->nombre}}</option>
                        @else
                            <option value="{{$item->id}}"  {{(in_array($item->id, old('categorias', [])))?'selected': ''}}>{{$item->nombre}}</option>
                        @endif
                         
                        @endforeach
                    </select>
                     @error('categorias')
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
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

@endpush