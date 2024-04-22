<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">inicio</div>
                <a class="nav-link" href="{{route('panel')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    panel
                </a>

                <div class="sb-sidenav-menu-heading">Modulos</div>
                <a class="nav-link" href="{{route('categorias.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tag"></i></div>
                    Categorias
                </a>
                <a class="nav-link" href="{{route('marcas.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                    Marcas
                </a>

                <a class="nav-link" href="{{route('presentaciones.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                    Presentaciones
                </a>

                <a class="nav-link" href="{{route('productos.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                    Productos
                </a>

                
                <a class="nav-link" href="{{route('clientes.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    clientes
                </a>

                <a class="nav-link" href="{{route('proveedores.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-truck-field"></i></div>
                    proveedores
                </a>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                    Compras
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('compras.index')}}">ver</a>
                        <a class="nav-link" href="{{route('compras.create')}}">crear</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                    ventas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('ventas.index')}}">ver</a>
                        <a class="nav-link" href="{{route('ventas.create')}}">crear</a>
                    </nav>
                </div>

               
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
            Usuario
        </div>
    </nav>
</div>