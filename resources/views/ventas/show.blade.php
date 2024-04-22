@extends('template')

@section('title', 'ver compra')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush
@section('content')
<div class="container-fluid px-4">
    
    <h1 class="mt-4 text-center">ver compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('compras.index')}}" class="href">compras</a></li>
        <li class="breadcrumb-item active">ver compra</li>
    </ol>

</div>

<div class="conainer w-100 border border-3  p-4 mt-3">
    <div class="card p-2 mb-2">
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input disabled type="text" class="form-control" value="tipo de comprobante: ">
            </div>
        </div>

        <div class="col-sm-8">
                <input  disabled type="text" class="form-control" value="{{$compra->comprobante->tipo_comprobante}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                <input disabled type="text" class="form-control" value="numero de comprobante: ">
            </div>
        </div>

        <div class="col-sm-8">
                <input  disabled type="text" class="form-control" value="{{$compra->numero_comprobante}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                <input disabled type="text" class="form-control" value="Proveedor : ">
            </div>
        </div>

        <div class="col-sm-8">
                <input  disabled type="text" class="form-control" value="{{$compra->proveedore->persona->razon_social}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                <input disabled type="text" class="form-control" value="Fecha : ">
            </div>
        </div>

        <div class="col-sm-8">
                <input  disabled type="text" class="form-control" value="{{\carbon\carbon::parse($compra->fecha_hora)->format('d-m-y')}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                <input disabled type="text" class="form-control" value="Hora : ">
            </div>
        </div>

        <div class="col-sm-8">
                <input  disabled type="text" class="form-control" value="{{\carbon\carbon::parse($compra->fecha_hora)->format('h:i')}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                <input disabled type="text" class="form-control" value="Impuesto : ">
            </div>
        </div>

        <div class="col-sm-8">
                <input  disabled type="text" class="form-control" id="iva" value="{{$compra->impuesto}}">
        </div>
    </div>
</div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            tabla de detalle de la compra
        </div>

        <div class="card-body table-responsive">
            <table class="table table-stripped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Producto</th>
                        <th>cantidad</th>
                        <th>precio de compra</th>
                        <th>precio de venta</th>
                        <th>subtotal</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->productos as $compra_producto)
                        <tr>
                            <td>
                                {{$compra_producto->nombre}}
                            </td>
                            <td>
                                {{$compra_producto->pivot->cantidad}}
                            </td>
                            <td>
                                {{$compra_producto->pivot->precio_compra}}
                            </td>
                            <td>
                                {{$compra_producto->pivot->precio_venta}}
                            </td>
                            <td class="td-subtotal">
                                {{$compra_producto->pivot->cantidad*$compra_producto->pivot->precio_compra}}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                    <tr>
                        <th colspan="5"></th>
                    </tr>
                    <tr>
                        <th colspan="4">sumas</th>
                        <th id="th_suma"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Iva</th>
                        <th id="th_iva"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Total</th>
                        <th id="th_total"></th>
                    </tr>
                <tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    let filaSubtotal = document.getElementsByClassName('td-subtotal')
    let cont = 0;
    let iva = $("#iva").val()
    $(document).ready(function(){
        calcularValores();
    });

    function calcularValores(){
        for(let i=0; i < filaSubtotal.length; i++){
            cont += parseFloat(filaSubtotal[i].innerHTML);
        }

        $('#th_suma').html(cont);
        $('#th_iva').html(iva);
        $('#th_total').html(parseFloat(iva)+parseFloat(cont))
    }
</script>
@endpush