@extends('layouts.public')
@section('title','Anuncios')

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
<section class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-success mb-0">
      <i class="fas fa-bullhorn"></i> Anuncios
    </h2>
    @auth
      @if(auth()->user()->isVendedor() || auth()->user()->isAdmin())
        <div class="btn-group">
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus-circle"></i> Publicar Anuncio
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('ganados.create') }}">
              <i class="fas fa-cow"></i> Publicar Animal
            </a>
            <a class="dropdown-item" href="{{ route('maquinarias.create') }}">
              <i class="fas fa-tractor"></i> Publicar Maquinaria
            </a>
            <a class="dropdown-item" href="{{ route('organicos.create') }}">
              <i class="fas fa-leaf"></i> Publicar Orgánico
            </a>
          </div>
        </div>
      @endif
    @endauth
  </div>

  {{-- Buscador y Filtros --}}
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('ads.index') }}" class="row align-items-end">
        <div class="col-md-4 mb-2">
          <label class="small font-weight-bold mb-1">Categoría</label>
          <select name="categoria_id" class="form-control">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $categoria)
              <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6 mb-2">
          <label class="small font-weight-bold mb-1">Buscar</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-success text-white"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" name="q" class="form-control" placeholder="Buscar productos, marcas, lugares..." value="{{ request('q') }}">
          </div>
        </div>
        <div class="col-md-2 mb-2">
          <button type="submit" class="btn btn-success btn-block">
            <i class="fas fa-search"></i> Buscar
          </button>
        </div>
      </form>
      @if(request()->has('q') || request()->has('categoria_id'))
        <div class="mt-2">
          <a href="{{ route('ads.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times"></i> Limpiar filtros
          </a>
        </div>
      @endif
    </div>
  </div>

  {{-- Resultados --}}
  @php
    $totalResultados = 0;
    if (method_exists($ganados, 'total')) $totalResultados += $ganados->total();
    elseif ($ganados->count() > 0) $totalResultados += $ganados->count();
    if (method_exists($maquinarias, 'total')) $totalResultados += $maquinarias->total();
    elseif ($maquinarias->count() > 0) $totalResultados += $maquinarias->count();
    if (method_exists($organicos, 'total')) $totalResultados += $organicos->total();
    elseif ($organicos->count() > 0) $totalResultados += $organicos->count();
  @endphp

  @if($totalResultados > 0 || (!request()->has('q') && !request()->has('categoria_id') && !request()->has('tipo')))
    {{-- GANADOS --}}
    @if(isset($ganados) && ($ganados->count() > 0 || (method_exists($ganados, 'total') && $ganados->total() > 0)))
      <div class="mb-4">
        <h4 class="text-primary mb-3">
          <i class="fas fa-cow"></i> Animales 
          @if(method_exists($ganados, 'total'))
            <span class="badge badge-info">({{ $ganados->total() }})</span>
          @else
            <span class="badge badge-info">({{ $ganados->count() }})</span>
          @endif
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
                           class="ad-img ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $ganado->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
                      <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                  @endif
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-tag text-success mr-1"></i>{{ $ganado->nombre }}
                    </h5>
                    <ul class="ad-meta list-unstyled mb-2">
                      @if($ganado->ubicacion)
                        <li class="mb-1"><i class="fas fa-map-marker-alt text-success"></i> <span class="small">{{ Str::limit($ganado->ubicacion, 40) }}</span></li>
                      @endif
                      @if($ganado->tipoAnimal)
                        <li class="mb-1"><i class="fas fa-paw text-success"></i> <span class="small">{{ $ganado->tipoAnimal->nombre }}</span></li>
                      @endif
                      @if($ganado->edad)
                        <li class="mb-1"><i class="fas fa-birthday-cake text-success"></i> <span class="small">{{ $ganado->edad }} meses</span></li>
                      @endif
                      @if($ganado->fecha_publicacion)
                        <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i> <span class="small">Publicado: {{ \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y') }}</span></li>
                      @endif
                    </ul>
                    <div class="mb-2">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> {{ $ganado->categoria->nombre ?? 'Animales' }}
                      </span>
                    </div>
                    @if($ganado->precio)
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> {{ number_format($ganado->precio, 2) }}
                        </h4>
                      </div>
                    @else
                      <div class="bg-light p-2 rounded mb-2 border-left border-secondary border-3">
                        <span class="text-muted small">Precio a consultar</span>
                      </div>
                    @endif
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-success border-2 p-2">
                    @if($ganado->precio)
                      <span class="price font-weight-bold text-success">Bs {{ number_format($ganado->precio, 2) }}</span>
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
        @if(method_exists($ganados, 'links'))
          <div class="mt-3">
            {{ $ganados->appends(request()->except('ganados_page'))->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- MAQUINARIAS --}}
    @if(isset($maquinarias) && ($maquinarias->count() > 0 || (method_exists($maquinarias, 'total') && $maquinarias->total() > 0)))
      <div class="mb-4">
        <h4 class="text-primary mb-3">
          <i class="fas fa-tractor"></i> Maquinaria 
          @if(method_exists($maquinarias, 'total'))
            <span class="badge badge-info">({{ $maquinarias->total() }})</span>
          @else
            <span class="badge badge-info">({{ $maquinarias->count() }})</span>
          @endif
        </h4>
        <div class="row">
          @foreach($maquinarias as $maquinaria)
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
                           class="ad-img ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $maquinaria->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="ad-img bg-light d-flex align-items-center justify-content-center maquinaria-card-wrapper" style="height:220px; border-bottom: 3px solid #28a745; position: relative;">
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
                      @if($maquinaria->created_at)
                        <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i> <span class="small">Publicado: {{ \Carbon\Carbon::parse($maquinaria->created_at)->format('d/m/Y') }}</span></li>
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
            {{ $maquinarias->appends(request()->except('maquinarias_page'))->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- ORGÁNICOS --}}
    @if(isset($organicos) && ($organicos->count() > 0 || (method_exists($organicos, 'total') && $organicos->total() > 0)))
      <div class="mb-4">
        <h4 class="text-primary mb-3">
          <i class="fas fa-leaf"></i> Orgánicos 
          @if(method_exists($organicos, 'total'))
            <span class="badge badge-info">({{ $organicos->total() }})</span>
          @else
            <span class="badge badge-info">({{ $organicos->count() }})</span>
          @endif
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
                           class="ad-img ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="{{ $organico->nombre }}">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  @else
                    <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
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
            {{ $organicos->appends(request()->except('organicos_page'))->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- Sin resultados --}}
    @if($totalResultados == 0 && (request()->has('q') || request()->has('categoria_id') || request()->has('tipo')))
      <div class="alert alert-info text-center py-5">
        <i class="fas fa-search fa-3x mb-3"></i>
        <h4>No se encontraron resultados</h4>
        <p>Intenta con otros términos de búsqueda o <a href="{{ route('ads.index') }}">ver todos los anuncios</a></p>
      </div>
    @endif
  @else
    {{-- Sin productos en la base de datos --}}
    <div class="alert alert-warning text-center py-5">
      <i class="fas fa-info-circle fa-3x mb-3"></i>
      <h4>No hay anuncios disponibles</h4>
      <p>Los vendedores aún no han publicado productos.</p>
    </div>
  @endif

</section>
@endsection
