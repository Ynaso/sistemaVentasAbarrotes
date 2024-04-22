@extends('template')

@section('title', 'categorias')

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
    
    <h1 class="mt-4 text-center">Proveedores</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">Inicio</a></li>
        <li class="breadcrumb-item active">Proveedores</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('proveedores.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo Proveedor</button></a>
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
                        <th>Razon social</th>
                        <th>Direccion</th>
                        <th>Documento</th>
                        <th>Tipo de Proveedor</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr> 
                           <td>
                               {{$proveedor->persona->razon_social}}
                           </td> 
                           
                           <td>
                               {{$proveedor->persona->direccion}}
                           </td>     

                           <td>
                                {{$proveedor->persona->Documento->tipo_documento.' '.$proveedor->persona->numero_documento}}
                           </td>  
                     
                           <td>
                            {{$proveedor->persona->tipo_persona}}
                           </td>     
                          
                           <td>
                                @if ($proveedor->persona->estado == 1)
                                <span class="fw-bolder rounded bg-success text-white p-1">Activo</span>
                                @else
                                <span class="fw-bolder rounded bg-danger text-white p-1">Inactivo</span>    
                                @endif
                        
                            </td>
                           
                            
                        
                          
                           <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('proveedores.edit', ['proveedore'=>$proveedor])}}" method="GET" >
                                    <button type="submit" class="btn btn-warning">Editar</button>
                                </form>

                                @if ($proveedor->persona->estado==0)
                                <form id="formSecundario" action="#" method="POST">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$proveedor->id}}">restaurar</button>
                                </form>
                                @else
                                <form id="formSecundario" action="#" method="POST">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$proveedor->id}}">Eliminar</button>
                                </form>
                                @endif
                            </div>
                                
                           </td>     
   
                       </tr>
                            <div class="modal fade" id="confirmModal-{{$proveedor->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="confirmModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    {{$proveedor->persona->estado==0?'deseas retaurar este proveedor?': 'deseas eliminar este proveedor?'}}
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{route('proveedores.destroy', ['proveedore'=>$proveedor->persona->id])}}" method="post" >
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