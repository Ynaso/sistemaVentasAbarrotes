@extends('template')

@section('title', 'crear compra')

@push ('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="container-fluid px-4">
    
    <h1 class="mt-4 text-center">crear compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}" class="href">Inicio</a></li>
        <li class="breadcrumb-item active">Compras</li>
    </ol>
</div>


<form action= "{{route('compras.store')}}" method="post">
    @csrf
    <div class='container mt-4'>
        <div class ="row gy-4">

            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    detalles de la compra
                </div>

                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="producto_id" class="form-label">Producto: </label>
                            <select name="producto_id" id="producto_id" class="form-control selectpicker show-tick" data-live-search="true" title="busca tu producto aca" data-size="1">

                                
                            @foreach($productos as $producto)
                                <option value="{{$producto->id}}">{{$producto->codigo."   ". $producto->nombre}}</option>
                             @endforeach
                            </select>

                            @error('producto_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror   
                        </div>

                        <div class="col-md-4 mb-2">
                           <label for="cantidad" class="form-label">Cantidad: </label>
                           <input type="number" name="cantidad" id="cantidad" class="form-control" step="0.1">

                           @error('cantidad')
                                <small class="text-danger">{{'*'.$message}}</small>
                           @enderror
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="precio_compra" class="form-label">Precio de compra: </label>
                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">

                            @error('precio_compra')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                         </div>

                         <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta: </label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                            
                            @error('precio_venta')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                         </div>

                         
                         <div class="col-md-12 mb-2 text-end">
                           <button class="btn btn-primary" type="button" id="btn-agregar">Agregar</button>
                         </div>

                         <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalles" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>producto</th>
                                            <th>cantidad</th>
                                            <th>precio compra</th>
                                            <th>precio venta</th>
                                            <th>sub total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">sumas</th>
                                                <th colspan="2"><span id="sumas">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">IVA %</th>
                                                <th colspan="2"><span id="iva">0</span></th>
                                            </tr>

                                            <tr>
                                                <th></th>
                                                <th colspan="4">total</th>
                                                <th colspan="2"><input type="hidden" name="total" value="0" id ="inputTotal"><span id="total" name="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </tbody>
                                </table>
                            </div>

                            
                        <div class="col-md-3 mb-2">
                            <div class="row">
                                <button type="button" id="cancelarCompra" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">cancelar compra</button>
                            </div>
                        </div>


                         <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Estas seguro que deseas cancelar la compra??
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">salir</button>
                                <button type="button" id="btnCancelarCompra" class="btn btn-primary"  data-bs-dismiss="modal">cancelar compra</button>
                                </div>
                            </div>
                            </div>
                        </div>
                         </div>


                    </div>
                </div>

                
            </div>

            <div class="col-md-4">
                <div class="text-white bg-success p-1 text-center">
                    datos generales
                </div>

                <div class="p-3 border border-3 border-success">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Proveedor: </label>
                            <select name="proveedore_id" id="proveedore_id" class="form-control selectpicker show-tick" data-live-search="true" title="selecciona" data-size="2">

                                
                            @foreach($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}">{{$proveedor->persona->razon_social}}</option>
                             @endforeach
                            </select>

                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">comprobantes: </label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick" title="selecciona">

                                
                            @foreach($comprobantes as $comprobante)
                                <option value="{{$comprobante->id}}">{{$comprobante->tipo_comprobante}}</option>
                             @endforeach
                            </select>

                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="numero_comprobante" class="form-label">numero de comprobante: </label>
                            <input name="numero_comprobante" id="numero_comprobante" class="form-control" required/>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">impuesto: </label>
                            <input readonly type="text" name="impuesto" id="impuesto" class="form-control border-success text-center" />
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="fecha" class="form-label">fecha: </label>
                            <input type="date" readonly name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>" />
                            <?php
                                use Carbon\Carbon;
                            
                                $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>
                        
                            <input type="hidden" value="{{$fecha_hora}}" name="fecha_hora" id="fecha_hora">
                        </div>

                        <div class="col-md-12 mb-2 text-center">
                            <button type="submit" id ="guardarCompra" class="btn btn-success">Guardar</button>
                        </div>

                      
                    </div>
                </div>
            </div>

           

        </div>
    </div>
</form>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<script>

    
    $(document).ready(function(){
        $('#btn-agregar').click(function(){
            agregarProducto();
        });

        $('#btnCancelarCompra').click(function(){
            cancelarCompra();
        });

        disabledButtons();

        $('#impuesto').val(impuesto_iva + '%');
    })
    let cont = 0;
    let subtotal = [];
    let sumas = 0;
    let iva = 0;
    let total = 0;
    const impuesto_iva = 15;

   
    
    function cancelarCompra(){
        cont = 0;
        $('#tabla_detalles > tbody').empty();
        $('#sumas').html(0);
        $('#iva').html(0);
        $('#total').html(0);
        $('#inputTotal').val(total);
        disabledButtons();
    }

    function agregarProducto(){
        let idProducto = $('#producto_id').val();
        console.log(idProducto);
        let nameProducto = ($('#producto_id option:selected').text()).split('   ')[1];
        let cantidad = $('#cantidad').val();
        let precioCompra = $('#precio_compra').val();
        let precioVenta = $('#precio_venta').val();

        if(idProducto != "" && nameProducto != "" && cantidad != "" && precioCompra !="" && precioVenta != ""){
                    //calcular valores de la factura

                   
                    if(parseInt(cantidad) > 0 && cantidad % 1 == 0 && parseFloat(precioCompra) > 0 && parseFloat(precioVenta) > 0){


                        if(parseFloat(precioVenta) > parseFloat(precioCompra)){
                            subtotal[cont] = parseFloat((cantidad * precioCompra).toFixed(2));
                            sumas += subtotal[cont];
                            iva = parseFloat((sumas * impuesto_iva/100).toFixed(2));
                            total = parseFloat((sumas + iva).toFixed(2));
                            


                            let fila = '<tr id="fila'+cont+'">'+
                                            '<th>' + (cont + 1) + '</th>' +
                                            '<td><input type="hidden" name="arrayIdProducto[]" value="' + idProducto + '"/>' + nameProducto + '</td>' +
                                            '<td><input type="hidden" name="arrayCantidad[]" value="' + cantidad + '"/>' + cantidad + '</td>' +     
                                            '<td><input type="hidden" name="arrayPrecioCompra[]" value="' + precioCompra + '"/>' + precioCompra + '</td>' +
                                            '<td><input type="hidden" name="arrayPrecioVenta[]" value="' + precioVenta + '"/>' + precioVenta + '</td>' +
                                            '<td>'+  subtotal[cont] + '</td>' +
                                            '<td><button type="button" onClick="eliminarProducto(' + cont + ')" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>' +
                                        '</tr>';

                            $('#tabla_detalles').append(fila);
                            LimpiarCampos();
                            cont++;

                            //rellenar campos calculados
                            $('#sumas').html(sumas);
                            $('#iva').html(iva);
                            $('#total').html(total);
                            $('#impuesto').val(iva);
                            
                            $('#inputTotal').val(total);

                            disabledButtons();

                            
                        }
                        else{
                            let message = "vas a vender el producto mas barato de lo que te costo huh??";
                            ShowModal(message);   
                        }

                            
                    }else{
                        let message = "valores incorrectos";
                        ShowModal(message);
                    }
                
        }else{
            let message = "te faltan campos por llenar";
            ShowModal(message);
        }

       

    }


    function disabledButtons(){
        if(parseInt(total)==0){
            $('#guardarCompra').hide();
            $('#cancelarCompra').hide();
        }else{
            $('#guardarCompra').show();
            $('#cancelarCompra').show();
        }
    }

    function LimpiarCampos(){
        let select = $("#producto_id");
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_compra').val('');
        $('#precio_venta').val('');
    }

    function eliminarProducto(index){
        sumas -= parseFloat((subtotal[index]).toFixed(2));
        iva = parseFloat((sumas * impuesto_iva/100).toFixed(2));
        total = parseFloat((sumas + iva).toFixed(2));
        
        //rellenar campos calculados
        $('#sumas').html(sumas);
        $('#iva').html(iva);
        $('#total').html(total);
        $('#impuesto').val(iva);
        $('#fila'+index).remove();
        $('#inputTotal').val(total);
        disabledButtons();

    }


    function ShowModal(message, icon = 'error'){
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
        icon: icon,
        title: message
        });
    }
</script>

@endpush