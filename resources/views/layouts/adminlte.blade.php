<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Mercado Agrícola')</title>

  <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <style>
    /* Estilos para el panel de categorías estilo Facebook */
    .sidebar .nav-header {
      padding: 0.75rem 1rem 0.5rem;
      font-weight: 600;
      color: #cfe6d0;
      border-bottom: 1px solid rgba(207, 230, 208, 0.2);
      margin-bottom: 0.5rem;
    }
    
    .sidebar .nav-item .nav-link {
      transition: all 0.2s ease;
      border-radius: 8px;
      margin: 0.15rem 0.5rem;
    }
    
    .sidebar .nav-item .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(3px);
    }
    
    .sidebar .nav-item .nav-link.active {
      background-color: rgba(40, 167, 69, 0.3);
      border-left: 3px solid #28a745;
    }
    
    .sidebar .nav-item .nav-link i {
      width: 20px;
      text-align: center;
      margin-right: 0.5rem;
    }
    
    /* Scrollbar personalizado para categorías si hay muchas */
    .sidebar .nav-pills {
      max-height: calc(100vh - 200px);
      overflow-y: auto;
    }
    
    .sidebar .nav-pills::-webkit-scrollbar {
      width: 6px;
    }
    
    .sidebar .nav-pills::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.1);
    }
    
    .sidebar .nav-pills::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 3px;
    }
    
    .sidebar .nav-pills::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.5);
    }
  </style>
</head>

@yield('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<body class="hold-transition sidebar-mini layout-fixed theme-agro">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @auth
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user-circle"></i>
            <span class="d-none d-md-inline ml-1">{{ auth()->user()->name }}</span>
            <span class="badge badge-info ml-1">{{ auth()->user()->role_name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">
              {{ auth()->user()->name }}
              <br>
              <small>{{ auth()->user()->email }}</small>
            </span>
            <div class="dropdown-divider"></div>
            <a href="{{ route('home') }}" class="dropdown-item">
              <i class="fas fa-home mr-2"></i> Ir al Inicio
            </a>
            @if(auth()->user()->isCliente())
              <a href="{{ route('solicitar-vendedor') }}" class="dropdown-item">
                <i class="fas fa-user-tie mr-2"></i> Ser Vendedor
              </a>
            @endif
            @if(auth()->user()->isAdmin())
              <a href="{{ route('admin.solicitudes-vendedor.index') }}" class="dropdown-item">
                <i class="fas fa-clipboard-list mr-2"></i> Solicitudes de Vendedor
              </a>
            @endif
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="dropdown-item dropdown-footer">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
              </button>
            </form>
          </div>
        </li>
      @else
        <li class="nav-item">
          <a href="{{ route('login') }}" class="nav-link">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('register') }}" class="nav-link">
            <i class="fas fa-user-plus"></i> Registrarse
          </a>
        </li>


        
      @endauth
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ url('/') }}" class="brand-link">
      <span class="brand-text font-weight-light">Mercado Agrícola</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column">

          @auth
            {{-- ===== OPCIONES PARA VENDEDOR Y ADMIN ===== --}}
            @if(auth()->user()->isVendedor() || auth()->user()->isAdmin())
              <!-- GANADO -->
              <li class="nav-item">
                <a href="{{ route('ganados.index') }}"
                   class="nav-link {{ request()->routeIs('ganados.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-horse"></i>
                  <p>Animales</p>
                </a>
              </li>

              <!-- MAQUINARIA -->
              <li class="nav-item">
                <a href="{{ route('maquinarias.index') }}"
                   class="nav-link {{ request()->routeIs('maquinarias.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>Maquinaria</p>
                </a>
              </li>

              <!-- ORGÁNICOS -->
              <li class="nav-item">
                <a href="{{ route('organicos.index') }}"
                   class="nav-link {{ request()->routeIs('organicos.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-leaf"></i>
                  <p>Orgánicos</p>
                </a>
              </li>
            @endif

            {{-- ===== CARRITO DE COMPRAS (TODOS LOS USUARIOS) ===== --}}
            @if(auth()->check())
              <li class="nav-item">
                <a href="{{ route('cart.index') }}"
                   class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    Carrito
                    @php
                      $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('cantidad');
                    @endphp
                    @if($cartCount > 0)
                      <span class="badge badge-danger badge-sm float-right">{{ $cartCount }}</span>
                    @endif
                  </p>
                </a>
              </li>
            @endif

            {{-- ===== PANEL DE CATEGORÍAS ESTILO FACEBOOK ===== --}}
            @if(isset($categorias) && $categorias->count() > 0)
              <li class="nav-header mt-3 mb-2">
                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.7;">
                  <i class="fas fa-th-large mr-1"></i>Categorías
                </span>
              </li>
              
              @php
                // Mapeo de iconos para categorías comunes
                $iconosCategorias = [
                  'animal' => 'fa-cow',
                  'animales' => 'fa-cow',
                  'ganado' => 'fa-horse',
                  'maquinaria' => 'fa-tractor',
                  'tractor' => 'fa-tractor',
                  'orgánico' => 'fa-leaf',
                  'organicos' => 'fa-leaf',
                  'vehículo' => 'fa-car',
                  'vehículos' => 'fa-car',
                  'propiedad' => 'fa-home',
                  'inmueble' => 'fa-building',
                  'deporte' => 'fa-running',
                  'electrónica' => 'fa-mobile-alt',
                  'ropa' => 'fa-tshirt',
                  'mascota' => 'fa-paw',
                  'jardín' => 'fa-seedling',
                  'música' => 'fa-guitar',
                  'juego' => 'fa-gamepad',
                  'oficina' => 'fa-briefcase',
                  'hogar' => 'fa-home',
                  'familia' => 'fa-heart',
                  'entretenimiento' => 'fa-film',
                  'gratis' => 'fa-gift',
                  'clasificado' => 'fa-tag',
                  'afición' => 'fa-pencil-alt',
                ];
                
                // Función para obtener icono según nombre de categoría
                $obtenerIcono = function($nombre) use ($iconosCategorias) {
                  $nombreLower = strtolower($nombre);
                  foreach ($iconosCategorias as $key => $icono) {
                    if (strpos($nombreLower, $key) !== false) {
                      return $icono;
                    }
                  }
                  return 'fa-tag'; // Icono por defecto
                };
              @endphp
              
              @foreach($categorias->take(10) as $categoria)
                <li class="nav-item">
                  <a href="{{ route('ads.index', ['categoria_id' => $categoria->id]) }}"
                     class="nav-link {{ request('categoria_id') == $categoria->id ? 'active' : '' }}"
                     style="padding: 0.5rem 1rem;">
                    <i class="nav-icon fas {{ $obtenerIcono($categoria->nombre) }}"></i>
                    <p style="margin: 0; font-size: 0.9rem;">{{ $categoria->nombre }}</p>
                  </a>
                </li>
              @endforeach
              
              @if($categorias->count() > 10)
                <li class="nav-item">
                  <a href="{{ route('ads.index') }}" class="nav-link" style="padding: 0.5rem 1rem;">
                    <i class="nav-icon fas fa-ellipsis-h"></i>
                    <p style="margin: 0; font-size: 0.85rem; opacity: 0.8;">Ver todas</p>
                  </a>
                </li>
              @endif
            @endif

            {{-- ===== OPCIONES SOLO PARA ADMIN ===== --}}
            @if(auth()->user()->isAdmin())
              <li class="nav-header">CONFIGURACIÓN</li>
              
              <!-- CATEGORÍAS -->
              <li class="nav-item">
                <a href="{{ route('admin.categorias.index') }}"
                   class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>Categorías</p>
                </a>
              </li>

              <!-- TIPOS DE ANIMAL -->
              <li class="nav-item">
                <a href="{{ route('admin.tipo_animals.index') }}"
                   class="nav-link {{ request()->routeIs('admin.tipo_animals.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-paw"></i>
                  <p>Tipos de Animal</p>
                </a>
              </li>

              <!-- TIPO DE PESO -->
              <li class="nav-item">
                <a href="{{ route('admin.tipo-pesos.index') }}"
                   class="nav-link {{ request()->routeIs('admin.tipo-pesos.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-weight-hanging"></i>
                  <p>Tipo de Peso</p>
                </a>
              </li>

              <!-- DATOS SANITARIOS -->
              <li class="nav-item">
                <a href="{{ route('admin.datos-sanitarios.index') }}"
                   class="nav-link {{ request()->routeIs('admin.datos-sanitarios.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-syringe"></i>
                  <p>Datos Sanitarios</p>
                </a>
              </li>

              <!-- RAZAS -->
              <li class="nav-item">
                <a href="{{ route('admin.razas.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.razas.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-dna"></i>
                  <p>Razas</p>
                </a>
              </li>

              <!-- TIPOS DE MAQUINARIA -->
              <li class="nav-item">
                <a href="{{ route('admin.tipo_maquinarias.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.tipo_maquinarias.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>Tipos de Maquinaria</p>
                </a>
              </li>

              <!-- MARCAS DE MAQUINARIA -->
              <li class="nav-item">
                <a href="{{ route('admin.marcas_maquinarias.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.marcas_maquinarias.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tag"></i>
                  <p>Marcas de Maquinaria</p>
                </a>
              </li>

              <!-- ESTADOS DE MAQUINARIA -->
              <li class="nav-item">
                <a href="{{ route('admin.estado_maquinarias.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.estado_maquinarias.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-check-circle"></i>
                  <p>Estados de Maquinaria</p>
                </a>
              </li>

              <!-- UNIDADES DE ORGÁNICO -->
              <li class="nav-item">
                <a href="{{ route('admin.unidades_organicos.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.unidades_organicos.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Unidades de Orgánico</p>
                </a>
              </li>

              <li class="nav-header">GESTIÓN</li>

              <!-- DASHBOARD -->
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                  class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Dashboard</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.pedidos.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-receipt"></i>
                  <p>Pedidos</p>
                </a>
              </li>


              <!-- SOLICITUDES DE VENDEDOR -->
              <li class="nav-item">
                <a href="{{ route('admin.solicitudes-vendedor.index') }}"
                   class="nav-link {{ request()->routeIs('admin.solicitudes-vendedor.*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p>Solicitudes de Vendedor</p>
                </a>
              </li>
            @endif

            {{-- ===== OPCIONES SOLO PARA CLIENTE ===== --}}
            @if(auth()->user()->isCliente())
              <li class="nav-item">
                <a href="{{ route('solicitar-vendedor') }}"
                   class="nav-link {{ request()->routeIs('solicitar-vendedor*') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-user-tie"></i>
                  <p>Solicitar ser Vendedor</p>
                </a>
              </li>
            @endif

                    {{-- ===== CERRAR SESIÓN EN SIDEBAR ===== --}}
        <li class="nav-item mt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="nav-link text-left"
                        style="background: none; border: none; color: #cfe6d0;">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Cerrar Sesión</p>
                </button>
            </form>
        </li>

          @endauth

        </ul>

      </nav>
    </div>

  </aside>
  <!-- /.sidebar -->

  <!-- Content -->
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <h1>@yield('page_title','Panel')</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>

  </div>

  <!-- Footer -->
  <footer class="main-footer text-sm text-center">
    © {{ date('Y') }} Mercado Agrícola
  </footer>

</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">
          <i class="fas fa-exclamation-triangle mr-2"></i>Confirmar Eliminación
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="mb-3">
          <i class="fas fa-trash-alt fa-4x text-danger"></i>
        </div>
        <h5 id="confirmDeleteMessage">¿Está seguro de eliminar este registro?</h5>
        <p class="text-muted mt-3">Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">
          <i class="fas fa-times mr-2"></i>Cancelar
        </button>
        <form id="confirmDeleteForm" method="POST" style="display: inline;">
          <button type="submit" class="btn btn-danger btn-lg">
            <i class="fas fa-trash mr-2"></i>Eliminar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
// Script para reemplazar confirm() con modal de confirmación
$(document).ready(function() {
  // Función para configurar y mostrar el modal
  function showConfirmModal($form, message) {
    // Configurar el modal
    $('#confirmDeleteMessage').text(message);
    $('#confirmDeleteForm').attr('action', $form.attr('action'));
    
    // Limpiar el formulario del modal
    $('#confirmDeleteForm').find('input[type="hidden"]').remove();
    
    // Copiar todos los campos ocultos del formulario original al modal
    $form.find('input[type="hidden"]').each(function() {
      var $input = $(this);
      var name = $input.attr('name');
      var value = $input.val() || '';
      
      // Escapar el valor para evitar problemas con comillas y caracteres especiales
      var escapedValue = $('<div>').text(value).html();
      var escapedName = $('<div>').text(name).html();
      
      // Crear y agregar el campo oculto usando jQuery para mayor seguridad
      var $hiddenInput = $('<input>').attr({
        type: 'hidden',
        name: escapedName,
        value: escapedValue
      });
      $('#confirmDeleteForm').append($hiddenInput);
    });
    
    // Si no hay método definido, usar POST por defecto
    if (!$form.find('input[name="_method"]').length && !$form.attr('method')) {
      $('#confirmDeleteForm').append('<input type="hidden" name="_method" value="POST">');
    }
    
    // Si no hay token CSRF, agregarlo
    if (!$form.find('input[name="_token"]').length) {
      var csrfToken = $('meta[name="csrf-token"]').attr('content');
      if (csrfToken) {
        $('#confirmDeleteForm').append('<input type="hidden" name="_token" value="' + csrfToken + '">');
      }
    }
    
    // Mostrar el modal
    $('#confirmDeleteModal').modal('show');
  }
  
  // Interceptar todos los formularios con onsubmit que contengan confirm()
  $('form[onsubmit*="confirm"]').each(function() {
    var $form = $(this);
    var originalOnsubmit = $form.attr('onsubmit');
    
    // Extraer el mensaje del confirm
    var messageMatch = originalOnsubmit.match(/confirm\(['"](.*?)['"]\)/);
    var message = messageMatch ? messageMatch[1] : '¿Está seguro de eliminar este registro?';
    
    // Remover el onsubmit original
    $form.removeAttr('onsubmit');
    
    // Agregar evento click al botón submit
    $form.find('button[type="submit"], input[type="submit"]').on('click', function(e) {
      e.preventDefault();
      showConfirmModal($form, message);
    });
  });
  
  // Interceptar botones con onclick que contengan confirm()
  $('button[onclick*="confirm"], a[onclick*="confirm"]').each(function() {
    var $button = $(this);
    var originalOnclick = $button.attr('onclick');
    
    // Extraer el mensaje del confirm
    var messageMatch = originalOnclick.match(/confirm\(['"](.*?)['"]\)/);
    var message = messageMatch ? messageMatch[1] : '¿Está seguro de eliminar este registro?';
    
    // Buscar el formulario asociado
    var $form = $button.closest('form');
    
    if ($form.length > 0) {
      // Remover el onclick original
      $button.removeAttr('onclick');
      
      // Agregar evento click
      $button.on('click', function(e) {
        e.preventDefault();
        showConfirmModal($form, message);
      });
    }
  });
});
</script>

</body>
</html>
