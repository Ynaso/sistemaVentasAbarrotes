@extends('template')

@section('title', 'Productos')

@push ('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@section('content')
@if(session('success'))
    <script>
        let mensaje = "{{session('success')}}";
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: "success",
        title: mensaje
        });
    </script>
@endif
<div class="container-fluid px-4">
    
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">Inicio</a></li>
        <li class="breadcrumb-item active">Productos</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('productos.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo Producto</button></a>
    </div>
   


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>codigo</th>
                        <th>nombre</th>
                  
                        <th>marca</th>
                        <th>presentacion</th>
                        <th>categorias</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>

                
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr> 
                           <td>
                               {{$producto->codigo}}
                           </td> 
                           
                           <td>
                               {{$producto->nombre}}
                           </td>     


                         
                          <td>
                            {{$producto->marca->caracteristica->nombre}}
                          </td>     

                          <td>
                            {{$producto->presentacione->caracteristica->nombre}}
                          </td>     

                          <td>
                           @foreach($producto->categorias as $category)
                                <div class="container">
                                    <div class="row">
                                        <span class="m-1 rounded-pill bg-secondary text-white text-center">{{$category->caracteristica->nombre}}</span>
                                    </div>
                                </div>
                           @endforeach
                          </td>     
                          
                           <td>
                                @if ($producto->estado == 1)
                                <span class="fw-bolder rounded bg-success text-white p-1">Activo</span>
                                @else
                                <span class="fw-bolder rounded bg-danger text-white p-1">Inactivo</span>    
                                @endif
                           
                           </td>
                          
                           <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('productos.edit', ['producto'=>$producto])}}" method="GET" >
                                    <button type="submit" class="btn btn-warning">Editar</button>
                                </form>

                                <form id="formSecundario" action="#" method="POST">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verModal-{{$producto->id}}">ver</button>
                                </form>

                                @if ($producto->estado==0)
                                <form id="formSecundario" action="#" method="POST">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$producto->id}}">restaurar</button>
                                </form>
                                @else
                                <form id="formSecundario" action="#" method="POST">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$producto->id}}">Eliminar</button>
                                </form>
                                @endif
                            </div>
                                
                           </td>     
   
                       </tr>

                       <div class="modal fade" id="verModal-{{$producto->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="confirmModalLabel">Modal title</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row mb-3">
                                <label for="">
                                  <span class="fw-bolder">Descripcion: {{$producto->descripcion}}</span>
                                </label>
                              </div>
                              <div class="row mb-3">
                                <label for="">
                                  <span class="fw-bolder">fecha de vencimiento: {{$producto->fecha_vencimiento==''?'no tiene': $producto->fecha_vencimiento}}</span>
                                </label>
                              </div>
                              <div class="row mb-3">
                                <label for="">
                                  <span class="fw-bolder">stock: {{$producto->stock}}</span>
                                </label>
                              </div>
                              <div class="row mb-3">
                                <label for="fw-bolder">Imagen: </label>
                                <div> @if ($producto->img_path != null) <img src="{{Storage::url('public/productos/'.$producto->img_path)}}" alt="{{$producto->nombre}}" class="img-fluid img-thumbnail border border-4 rounded"> @else <img src="" alt="{{$producto->nombre}}"> @endif </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                              <form action="{{route('productos.destroy', ['producto'=>$producto->id])}}" method="post"> @method('DELETE') @csrf <button type="submit" class="btn btn-primary">Confirmar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                        </div>


                          <div class="modal fade" id="confirmModal-{{$producto->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="confirmModalLabel">Eliminar Producto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                {{$producto->estado==1?'deseas eliminar este Producto?': 'deseas restaurar este Producto?'}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{route('productos.destroy', ['producto'=>$producto->id])}}" method="post" >
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                </form>
                                
                                </div>
                            </div>
                            </div>
                        </div>

                    @endforeach
               </tbody>
              
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="{{asset('js/datatables-simple-demo.js')}}"></script>

@endpush