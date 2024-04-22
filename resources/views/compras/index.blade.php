@extends('template')

@section('title', 'compras')

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
    
    <h1 class="mt-4 text-center">compras</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">Inicio</a></li>
        <li class="breadcrumb-item active">Compras</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('compras.create')}}"><button type="button" class="btn btn-primary">Añadir nueva compra</button></a>
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
                        <th>comprobante</th>
                        <th>proveedor</th>
                        <th>fecha y hora</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                    <tr>
                        <td>
                            <p class="fw-semibold mb-1">
                                {{$compra->comprobante->tipo_comprobante}}
                            </p>
                            <p class="text-muted mb-0">
                                {{$compra->numero_comprobante}}
                            </p>
                        </td>
                
                        <td>
                            <p class="fw-semibold mb-1">
                                {{ucfirst($compra->Proveedore->persona->tipo_persona)}}
                            </p>
                            <p class="text-muted mb-0">
                                {{$compra->Proveedore->persona->razon_social}}
                            </p>
                        </td>
                
                        <td>
                            {{

                                \carbon\carbon::parse($compra->fecha_hora)->format('d-m-y') .' '.
                                \carbon\carbon::parse($compra->fecha_hora)->format('h:i');
                            }}
                        </td>
                
                        <td>
                            {{$compra->total}}
                        </td>
                
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('compras.show',['compra'=>$compra])}}">
                                    <button type="submit" class="btn btn-success">ver compra</button>
                                </form>
                                <form id="formSecundario" action="#" method="POST">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$compra->id}}">Anular</button>
                                </form>                           
                            </div>
                        </td>
                    </tr>


                    <div class="modal fade" id="confirmModal-{{$compra->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="confirmModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                deseas eliminar la compra?? {{$compra->id}}
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <form action="{{route('compras.destroy', ['compra'=>$compra->id])}}" method="post" >
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




@endsection

@push('js')

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="{{asset('js/datatables-simple-demo.js')}}"></script>

@endpush