@extends('layouts.public')
@section('title','Inicio')

@section('content')
<style>
  .ganado-card {
    transition: all 0.3s ease;
    border: 3px solid #28a745 !important;
    background: #ffffff;
  }
  
  .ganado-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(40, 167, 69, 0.3) !important;
    border-color: #1e7e34 !important;
  }
  
  .ganado-img {
    transition: transform 0.3s ease;
  }
  
  .ganado-card:hover .ganado-img {
    transform: scale(1.05);
  }
  
  .card-img-wrapper {
    position: relative;
    overflow: hidden;
  }
  
  .badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
  }
  
  .bg-success-light {
    background-color: #d4edda !important;
  }
  
  .border-success {
    border-color: #28a745 !important;
  }
  
  /* Cinta de estado para maquinaria */
  .estado-cinta {
    position: absolute;
    top: 15px;
    left: -35px;
    width: 150px;
    padding: 5px 0;
    text-align: center;
    font-size: 0.75rem;
    font-weight: bold;
    color: white;
    transform: rotate(-45deg);
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  }
  
  .estado-cinta.disponible {
    background-color: #28a745;
  }
  
  .estado-cinta.en_mantenimiento {
    background-color: #ffc107;
    color: #000;
  }
  
  .estado-cinta.dado_baja {
    background-color: #dc3545;
  }
  
  .estado-cinta.en_uso {
    background-color: #007bff;
  }
  
  .maquinaria-card-wrapper {
    position: relative;
    overflow: hidden;
  }
</style>

<section class="hero" style="background:url('{{ asset('img/bg-agrovida.jpg') }}') center/cover no-repeat; min-height:400px; position:relative;">
  <div class="container py-5 text-white" style="position:relative; z-index:2;">
    <h5 class="mb-2">Bienvenido a Agrovida</h5>
    <h1 class="display-5 font-weight-bold">
      Tu mercado de animales, maquinaria y<br>orgánicos en un solo lugar
    </h1>

    <div class="bg-white p-4 rounded mt-4 shadow-lg">
      <form method="GET" action="{{ route('home') }}" id="searchForm" class="form-row align-items-end">
  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Categoría</label>
    <select name="categoria_id"
            class="form-control"
            onchange="this.form.submit()">
      <option value="">Todas las categorías</option>
      @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
          {{ $categoria->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Tipo de Animal</label>
    <select name="tipo_animal_id"
            id="tipo_animal_id"
            class="form-control"
            onchange="filtrarRazas(); this.form.submit();">
      <option value="">Todos los tipos</option>
      @foreach($tiposAnimales as $tipoAnimal)
        <option value="{{ $tipoAnimal->id }}" {{ request('tipo_animal_id') == $tipoAnimal->id ? 'selected' : '' }}>
          {{ $tipoAnimal->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Raza</label>
    <select name="raza_id"
            id="raza_id"
            class="form-control"
            onchange="this.form.submit()">
      <option value="">Todas las razas</option>
      @foreach($razas as $raza)
        <option value="{{ $raza->id }}" 
                data-tipo-animal-id="{{ $raza->tipo_animal_id }}"
                {{ request('raza_id') == $raza->id ? 'selected' : '' }}>
          {{ $raza->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Buscar</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text bg-success text-white"><i class="fas fa-search"></i></span>
      </div>
      <input type="text" name="q" class="form-control"
             placeholder="Buscar productos, marcas, lugares..."
             value="{{ request('q') }}">
    </div>
  </div>

  <div class="col-md-12 mb-2">
    <button type="submit" class="btn btn-success btn-block">
      <i class="fas fa-search"></i> Buscar
    </button>
  </div>
</form>

      @if(request()->has('q') || request()->has('categoria_id') || request()->has('tipo_animal_id') || request()->has('raza_id'))
        <div class="mt-2">
          <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times"></i> Limpiar filtros
          </a>
        </div>
      @endif
    </div>
  </div>
  <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.3); z-index:1;"></div>
</section>

@if(request()->has('q') || request()->has('categoria_id') || request()->has('tipo_animal_id') || request()->has('raza_id'))
  {{-- RESULTADOS DE BÚSQUEDA --}}
  <section class="container my-5">
    <h2 class="text-success mb-4">
      <i class="fas fa-search"></i> Resultados de búsqueda
      @if(request('q'))
        <small class="text-muted">para "{{ request('q') }}"</small>
      @endif
    </h2>

    {{-- GANADOS --}}
    @if(isset($ganados) && ($ganados->count() > 0 || (method_exists($ganados, 'total') && $ganados->total() > 0)))
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-cow"></i> Animales ({{ method_exists($ganados, 'total') ? $ganados->total() : $ganados->count() }})
        </h4>
        <div class="row">
          @foreach($ganados as $ganado)
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ route('ganados.show', $ganado->id) }}" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden" style="cursor: pointer;">
                  @php
                    $imagenPrincipal = $ganado->imagenes->first()->ruta ?? $ganado->imagen ?? null;
                  @endphp
                  @if($imagenPrincipal)
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                           class="card-img-top ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $ganado->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
                      <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-tag text-success mr-1"></i>{{ $ganado->nombre }}
                    </h5>
                    <div class="mb-2">
                      <p class="card-text text-muted small mb-1">
                        <i class="fas fa-map-marker-alt text-success"></i> 
                        <span class="ml-1">{{ Str::limit($ganado->ubicacion ?? 'Sin ubicación', 40) }}</span>
                      </p>
                      @if($ganado->fecha_publicacion)
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-calendar-alt text-success"></i> 
                          <span class="ml-1">Publicado: {{ \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y') }}</span>
                        </p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <span class="badge badge-success badge-lg px-3 py-2 mr-1 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $ganado->categoria->nombre ?? 'Sin categoría' }}
                      </span>
                      @if($ganado->tipoAnimal)
                        <span class="badge badge-info badge-lg px-3 py-2 shadow-sm">
                          <i class="fas fa-paw"></i> {{ $ganado->tipoAnimal->nombre }}
                        </span>
                      @endif
                    </div>
                    @if($ganado->precio)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($ganado->precio, 2) }}
                        </h4>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer bg-white border-top border-success border-2 p-2">
                    <div class="btn btn-success btn-block btn-lg shadow-sm font-weight-bold">
                      <i class="fas fa-eye mr-2"></i> Ver Detalles
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        @if(method_exists($ganados, 'links'))
          <div class="mt-3">
            {{ $ganados->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- MAQUINARIAS --}}
    @if(isset($maquinarias) && ($maquinarias->count() > 0 || (method_exists($maquinarias, 'total') && $maquinarias->total() > 0)))
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-tractor"></i> Maquinaria ({{ method_exists($maquinarias, 'total') ? $maquinarias->total() : $maquinarias->count() }})
        </h4>
        <div class="row">
          @foreach($maquinarias as $maquinaria)
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden" style="cursor: pointer;">
                  @php
                    $imagenPrincipal = $maquinaria->imagenes->first()->ruta ?? null;
                  @endphp
                  @if($imagenPrincipal)
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                           class="card-img-top ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $maquinaria->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745; position: relative;">
                      @if($maquinaria->estadoMaquinaria)
                        <div class="estado-cinta {{ $estadoNombre }}">
                          {{ $estadoTexto }}
                        </div>
                      @endif
                      <i class="fas fa-tractor fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-tag text-success mr-1"></i>{{ $maquinaria->nombre }}
                    </h5>
                    <ul class="ad-meta list-unstyled mb-2">
                      @if($maquinaria->ubicacion)
                        <li class="mb-1"><i class="fas fa-map-marker-alt text-success"></i> <span class="small">{{ Str::limit($maquinaria->ubicacion, 40) }}</span></li>
                      @endif
                      @if($maquinaria->tipoMaquinaria)
                        <li class="mb-1"><i class="fas fa-cog text-success"></i> <span class="small">{{ $maquinaria->tipoMaquinaria->nombre }}</span></li>
                      @endif
                      @if($maquinaria->fecha_publicacion ?? $maquinaria->created_at)
                        <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i> <span class="small">Publicado: {{ \Carbon\Carbon::parse($maquinaria->fecha_publicacion ?? $maquinaria->created_at)->format('d/m/Y') }}</span></li>
                      @endif
                    </ul>
                    <div class="mb-2">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $maquinaria->categoria->nombre ?? 'Maquinaria' }}
                      </span>
                    </div>
                    @if($maquinaria->precio_dia)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($maquinaria->precio_dia, 2) }}/día
                        </h4>
                      </div>
                    @else
                      <div class="bg-light p-2 rounded mb-2 border-left border-secondary border-3">
                        <span class="text-muted small">Precio a consultar</span>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-success border-2 p-2">
                    @if($maquinaria->precio_dia)
                      <span class="price font-weight-bold text-success">Bs {{ number_format($maquinaria->precio_dia, 2) }}/día</span>
                    @else
                      <span class="price font-weight-bold text-muted small">Consultar</span>
                    @endif
                    <div class="btn btn-success btn-sm px-3 shadow-sm font-weight-bold">
                      Ver Anuncio <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        @if(method_exists($maquinarias, 'links'))
          <div class="mt-3">
            {{ $maquinarias->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- ORGÁNICOS --}}
    @if(isset($organicos) && ($organicos->count() > 0 || (method_exists($organicos, 'total') && $organicos->total() > 0)))
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-leaf"></i> Orgánicos ({{ method_exists($organicos, 'total') ? $organicos->total() : $organicos->count() }})
        </h4>
        <div class="row">
          @foreach($organicos as $organico)
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ route('organicos.show', $organico->id) }}" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden" style="cursor: pointer;">
                  @php
                    $imagenPrincipal = $organico->imagenes->first()->ruta ?? null;
                  @endphp
                  @if($imagenPrincipal)
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                           class="card-img-top ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $organico->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
                      <i class="fas fa-leaf fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-leaf text-success mr-1"></i>{{ $organico->nombre ?? 'Orgánico' }}
                    </h5>
                    <ul class="ad-meta list-unstyled mb-2">
                      @if($organico->origen)
                        <li class="mb-1"><i class="fas fa-map-marker-alt text-success"></i> <span class="small">{{ Str::limit($organico->origen, 40) }}</span></li>
                      @endif
                      @if($organico->fecha_cosecha)
                        <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i> <span class="small">Cosecha: {{ \Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y') }}</span></li>
                      @endif
                      @if($organico->created_at)
                        <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i> <span class="small">Publicado: {{ \Carbon\Carbon::parse($organico->created_at)->format('d/m/Y') }}</span></li>
                      @endif
                    </ul>
                    <div class="mb-2">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $organico->categoria->nombre ?? 'Orgánico' }}
                      </span>
                    </div>
                    @if($organico->precio)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($organico->precio, 2) }}
                        </h4>
                      </div>
                    @else
                      <div class="bg-light p-2 rounded mb-2 border-left border-secondary border-3">
                        <span class="text-muted small">Precio a consultar</span>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-success border-2 p-2">
                    @if($organico->precio)
                      <span class="price font-weight-bold text-success">Bs {{ number_format($organico->precio, 2) }}</span>
                    @else
                      <span class="price font-weight-bold text-muted small">Consultar</span>
                    @endif
                    <div class="btn btn-success btn-sm px-3 shadow-sm font-weight-bold">
                      Ver Anuncio <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        @if(method_exists($organicos, 'links'))
          <div class="mt-3">
            {{ $organicos->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- SIN RESULTADOS --}}
    @if((!isset($ganados) || ($ganados->count() == 0 && (!method_exists($ganados, 'total') || $ganados->total() == 0))) &&
        (!isset($maquinarias) || ($maquinarias->count() == 0 && (!method_exists($maquinarias, 'total') || $maquinarias->total() == 0))) &&
        (!isset($organicos) || ($organicos->count() == 0 && (!method_exists($organicos, 'total') || $organicos->total() == 0))))
      <div class="alert alert-info text-center py-5">
        <i class="fas fa-search fa-3x mb-3"></i>
        <h4>No se encontraron resultados</h4>
        <p>Intenta con otros términos de búsqueda o <a href="{{ route('home') }}">ver todos los productos</a></p>
      </div>
    @endif
  </section>
@else
  {{-- PÁGINA INICIAL SIN BÚSQUEDA --}}
  <section class="container my-5">
    <div class="row align-items-center mb-5">
      <div class="col-md-5 mb-3">
        <img src="{{ asset('img/hero-agrovida.png') }}" class="img-fluid rounded shadow" alt="AgroVida">
      </div>
      <div class="col-md-7">
        <h3 class="text-success font-weight-bold">
          Miles de productos de nuestra industria a un click
        </h3>
        <p class="text-muted">
          Encuentra anuncios de productos y servicios especializados y a sus proveedores directos.
        </p>
        <div class="d-flex flex-column flex-md-row gap-3">
          <a href="{{ route('ads.index') }}" class="btn btn-success btn-lg px-5 shadow-sm">
            <i class="fas fa-search"></i> Navegar Anuncios
          </a>
          @auth
            @if(auth()->user()->isCliente())
              <a href="{{ route('solicitar-vendedor') }}" class="btn btn-primary btn-lg px-5 shadow-sm">
                <i class="fas fa-user-tie"></i> Ser Vendedor
              </a>
            @endif
          @else
            <a href="{{ route('solicitar-vendedor') }}" class="btn btn-primary btn-lg px-5 shadow-sm">
              <i class="fas fa-user-tie"></i> Ser Vendedor
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5">
              <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
          @endauth
        </div>
      </div>
    </div>

    {{-- PRODUCTOS DESTACADOS --}}
    @if(isset($ganados) && $ganados->count() > 0)
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-cow"></i> Animales Destacados
        </h3>
        <div class="row">
          @foreach($ganados->take(3) as $ganado)
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ route('ganados.show', $ganado->id) }}" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden" style="cursor: pointer;">
                  @php
                    $imagenPrincipal = $ganado->imagenes->first()->ruta ?? $ganado->imagen ?? null;
                  @endphp
                  @if($imagenPrincipal)
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                           class="card-img-top ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $ganado->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
                      <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-tag text-success mr-1"></i>{{ $ganado->nombre }}
                    </h5>
                    <div class="mb-2">
                      <p class="card-text text-muted small mb-1">
                        <i class="fas fa-map-marker-alt text-success"></i> 
                        <span class="ml-1">{{ Str::limit($ganado->ubicacion ?? 'Sin ubicación', 40) }}</span>
                      </p>
                      @if($ganado->fecha_publicacion)
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-calendar-alt text-success"></i> 
                          <span class="ml-1">Publicado: {{ \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y') }}</span>
                        </p>
                      @endif
                    </div>
                    <div class="mb-3">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $ganado->categoria->nombre ?? 'Sin categoría' }}
                      </span>
                    </div>
                    @if($ganado->precio)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($ganado->precio, 2) }}
                        </h4>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer bg-white border-top border-success border-2 p-2">
                    <div class="d-flex gap-2">
                      <div class="btn btn-success btn-sm flex-fill shadow-sm font-weight-bold">
                        <i class="fas fa-eye mr-1"></i> Ver
                      </div>
                      @auth
                        @if($ganado->precio && ($ganado->stock ?? 0) > 0)
                          <form action="{{ route('cart.add') }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
                            @csrf
                            <input type="hidden" name="product_type" value="ganado">
                            <input type="hidden" name="product_id" value="{{ $ganado->id }}">
                            <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="btn btn-success btn-sm shadow-sm" title="Agregar al carrito" onclick="event.stopPropagation();">
                              <i class="fas fa-cart-plus"></i>
                            </button>
                          </form>
                        @endif
                      @endauth
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="text-center">
          <a href="{{ route('ganados.index') }}" class="btn btn-outline-success">
            Ver todos los animales <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    @endif

    @if(isset($maquinarias) && $maquinarias->count() > 0)
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-tractor"></i> Maquinaria Destacada
        </h3>
        <div class="row">
          @foreach($maquinarias->take(3) as $maquinaria)
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden maquinaria-card-wrapper" style="cursor: pointer;">
                  @php
                    $imagenPrincipal = $maquinaria->imagenes->first()->ruta ?? null;
                    $estadoNombre = $maquinaria->estadoMaquinaria ? strtolower(str_replace(' ', '_', $maquinaria->estadoMaquinaria->nombre)) : 'disponible';
                    $estadoTexto = $maquinaria->estadoMaquinaria ? ucfirst(str_replace('_', ' ', $maquinaria->estadoMaquinaria->nombre)) : 'Disponible';
                  @endphp
                  @if($maquinaria->estadoMaquinaria)
                    <div class="estado-cinta {{ $estadoNombre }}">
                      {{ $estadoTexto }}
                    </div>
                  @endif
                  @if($imagenPrincipal)
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                           class="card-img-top ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $maquinaria->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745; position: relative;">
                      @if($maquinaria->estadoMaquinaria)
                        <div class="estado-cinta {{ $estadoNombre }}">
                          {{ $estadoTexto }}
                        </div>
                      @endif
                      <i class="fas fa-tractor fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-tag text-success mr-1"></i>{{ $maquinaria->nombre }}
                    </h5>
                    <div class="mb-2">
                      <p class="card-text text-muted small mb-1">
                        <i class="fas fa-map-marker-alt text-success"></i> 
                        <span class="ml-1">{{ Str::limit($maquinaria->ubicacion ?? 'Sin ubicación', 40) }}</span>
                      </p>
                    </div>
                    <div class="mb-3">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $maquinaria->categoria->nombre ?? 'Sin categoría' }}
                      </span>
                    </div>
                    @if($maquinaria->precio_dia)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($maquinaria->precio_dia, 2) }}/día
                        </h4>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer bg-white border-top border-success border-2 p-2">
                    <div class="d-flex gap-2">
                      <div class="btn btn-success btn-sm flex-fill shadow-sm font-weight-bold">
                        <i class="fas fa-eye mr-1"></i> Ver
                      </div>
                      @auth
                        @if($maquinaria->precio_dia)
                          <form action="{{ route('cart.add') }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
                            @csrf
                            <input type="hidden" name="product_type" value="maquinaria">
                            <input type="hidden" name="product_id" value="{{ $maquinaria->id }}">
                            <input type="hidden" name="cantidad" value="1">
                            <input type="hidden" name="dias_alquiler" value="1">
                            <button type="submit" class="btn btn-success btn-sm shadow-sm" title="Agregar al carrito" onclick="event.stopPropagation();">
                              <i class="fas fa-cart-plus"></i>
                            </button>
                          </form>
                        @endif
                      @endauth
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="text-center">
          <a href="{{ route('maquinarias.index') }}" class="btn btn-outline-success">
            Ver toda la maquinaria <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    @endif

    @if(isset($organicos) && $organicos->count() > 0)
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-leaf"></i> Productos Orgánicos Destacados
        </h3>
        <div class="row">
          @foreach($organicos->take(3) as $organico)
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="{{ route('organicos.show', $organico->id) }}" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden" style="cursor: pointer;">
                  @php
                    $imagenPrincipal = $organico->imagenes->first()->ruta ?? null;
                  @endphp
                  @if($imagenPrincipal)
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                           class="card-img-top ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $organico->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
                      <i class="fas fa-leaf fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-leaf text-success mr-1"></i>{{ $organico->nombre ?? 'Orgánico' }}
                    </h5>
                    <div class="mb-2">
                      <p class="card-text text-muted small mb-1">
                        <i class="fas fa-map-marker-alt text-success"></i> 
                        <span class="ml-1">{{ Str::limit($organico->origen ?? 'Sin ubicación', 40) }}</span>
                      </p>
                    </div>
                    <div class="mb-3">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $organico->categoria->nombre ?? 'Sin categoría' }}
                      </span>
                    </div>
                    @if($organico->precio)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($organico->precio, 2) }}
                        </h4>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer bg-white border-top border-success border-2 p-2">
                    <div class="d-flex gap-2">
                      <div class="btn btn-success btn-sm flex-fill shadow-sm font-weight-bold">
                        <i class="fas fa-eye mr-1"></i> Ver
                      </div>
                      @auth
                        @if($organico->precio && ($organico->stock ?? 0) > 0)
                          <form action="{{ route('cart.add') }}" method="POST" class="d-inline" onclick="event.stopPropagation();">
                            @csrf
                            <input type="hidden" name="product_type" value="organico">
                            <input type="hidden" name="product_id" value="{{ $organico->id }}">
                            <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="btn btn-success btn-sm shadow-sm" title="Agregar al carrito" onclick="event.stopPropagation();">
                              <i class="fas fa-cart-plus"></i>
                            </button>
                          </form>
                        @endif
                      @endauth
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="text-center">
          <a href="{{ route('organicos.index') }}" class="btn btn-outline-success">
            Ver todos los orgánicos <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    @endif
  </section>
@endif

<script>
// Función para filtrar razas según el tipo de animal seleccionado
function filtrarRazas() {
    const tipoAnimalId = document.getElementById('tipo_animal_id').value;
    const razaSelect = document.getElementById('raza_id');
    const todasLasOpciones = razaSelect.querySelectorAll('option');
    
    // Mostrar/ocultar opciones según el tipo de animal
    todasLasOpciones.forEach(option => {
        if (option.value === '') {
            // Siempre mostrar la opción "Todas las razas"
            option.style.display = '';
        } else {
            const tipoAnimalIdRaza = option.getAttribute('data-tipo-animal-id');
            if (tipoAnimalId === '' || tipoAnimalIdRaza === tipoAnimalId) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });
    
    // Si se cambió el tipo de animal y la raza seleccionada no corresponde, limpiar la selección
    const razaSeleccionada = razaSelect.value;
    if (razaSeleccionada) {
        const opcionSeleccionada = razaSelect.querySelector(`option[value="${razaSeleccionada}"]`);
        if (opcionSeleccionada && opcionSeleccionada.style.display === 'none') {
            razaSelect.value = '';
        }
    }
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    filtrarRazas();
});
</script>
@endsection
