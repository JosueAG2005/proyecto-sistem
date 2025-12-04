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

  {{-- MIS PUBLICACIONES (Solo para vendedores) --}}
  @auth
    @if((auth()->user()->isVendedor() || auth()->user()->isAdmin()) && ($misGanados->count() > 0 || $misMaquinarias->count() > 0 || $misOrganicos->count() > 0))
      <div class="card shadow-sm mb-4 border-primary">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">
            <i class="fas fa-user-circle"></i> Mis Publicaciones
            <small class="ml-2">({{ $misGanados->count() + $misMaquinarias->count() + $misOrganicos->count() }} total)</small>
          </h4>
        </div>
        <div class="card-body">
          {{-- Mis Animales --}}
          @if($misGanados->count() > 0)
            <div class="mb-4">
              <h5 class="text-primary mb-3">
                <i class="fas fa-cow"></i> Mis Animales ({{ $misGanados->count() }})
              </h5>
              <div class="row">
                @foreach($misGanados as $ganado)
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm border-left-primary">
                      @php
                        $imagenPrincipal = $ganado->imagenes->first()->ruta ?? $ganado->imagen ?? null;
                      @endphp
                      @if($imagenPrincipal)
                        <img src="{{ asset('storage/'.$imagenPrincipal) }}" 
                             class="card-img-top" 
                             style="height:150px; object-fit:cover;"
                             alt="{{ $ganado->nombre }}">
                      @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                          <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                      @endif
                      <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $ganado->nombre }}</h6>
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-tag"></i> {{ $ganado->categoria->nombre ?? 'Sin categoría' }}
                        </p>
                        @if($ganado->fecha_publicacion)
                          <p class="card-text text-muted small mb-1">
                            <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y') }}
                          </p>
                        @endif
                        @if($ganado->precio)
                          <p class="mb-1"><strong class="text-success">Bs {{ number_format($ganado->precio, 2) }}</strong></p>
                        @endif
                      </div>
                      <div class="card-footer bg-white p-2">
                        <div class="btn-group btn-group-sm w-100">
                          <a href="{{ route('ganados.show', $ganado->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                          </a>
                          <a href="{{ route('ganados.edit', $ganado->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Mis Maquinarias --}}
          @if($misMaquinarias->count() > 0)
            <div class="mb-4">
              <h5 class="text-primary mb-3">
                <i class="fas fa-tractor"></i> Mis Maquinarias ({{ $misMaquinarias->count() }})
              </h5>
              <div class="row">
                @foreach($misMaquinarias as $maquinaria)
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm border-left-info">
                      <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                        <i class="fas fa-tractor fa-4x text-success"></i>
                      </div>
                      <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $maquinaria->nombre }}</h6>
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-tag"></i> {{ $maquinaria->categoria->nombre ?? 'Sin categoría' }}
                        </p>
                        @if($maquinaria->precio_dia)
                          <p class="mb-1"><strong class="text-success">Bs {{ number_format($maquinaria->precio_dia, 2) }}/día</strong></p>
                        @endif
                      </div>
                      <div class="card-footer bg-white p-2">
                        <div class="btn-group btn-group-sm w-100">
                          <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                          </a>
                          <a href="{{ route('maquinarias.edit', $maquinaria->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Mis Orgánicos --}}
          @if($misOrganicos->count() > 0)
            <div class="mb-4">
              <h5 class="text-primary mb-3">
                <i class="fas fa-leaf"></i> Mis Orgánicos ({{ $misOrganicos->count() }})
              </h5>
              <div class="row">
                @foreach($misOrganicos as $organico)
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm border-left-success">
                      <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                        <i class="fas fa-leaf fa-4x text-success"></i>
                      </div>
                      <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $organico->nombre }}</h6>
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-tag"></i> {{ $organico->categoria->nombre ?? 'Sin categoría' }}
                        </p>
                        @if($organico->precio)
                          <p class="mb-1"><strong class="text-success">Bs {{ number_format($organico->precio, 2) }}</strong></p>
                        @endif
                      </div>
                      <div class="card-footer bg-white p-2">
                        <div class="btn-group btn-group-sm w-100">
                          <a href="{{ route('organicos.show', $organico->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                          </a>
                          <a href="{{ route('organicos.edit', $organico->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
    @endif
  @endauth

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
              <div class="card h-100 shadow-sm rounded-lg card-ad border-0">
                <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-tractor fa-5x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title mb-2">{{ $maquinaria->nombre }}</h5>
                  <ul class="ad-meta list-unstyled mb-2">
                    @if($maquinaria->tipoMaquinaria)
                      <li><i class="fas fa-tag text-muted"></i> {{ $maquinaria->tipoMaquinaria->nombre }}</li>
                    @endif
                    @if($maquinaria->marcaMaquinaria)
                      <li><i class="fas fa-industry text-muted"></i> {{ $maquinaria->marcaMaquinaria->nombre }}</li>
                    @endif
                    @if($maquinaria->modelo)
                      <li><i class="fas fa-cog text-muted"></i> {{ $maquinaria->modelo }}</li>
                    @endif
                  </ul>
                  <span class="badge badge-info badge-pill px-3">
                    {{ $maquinaria->categoria->nombre ?? 'Maquinaria' }}
                  </span>
                  @if($maquinaria->estado)
                    <span class="badge badge-{{ $maquinaria->estado == 'disponible' ? 'success' : 'secondary' }} badge-pill px-3 ml-1">
                      {{ ucfirst(str_replace('_', ' ', $maquinaria->estado)) }}
                    </span>
                  @endif
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top">
                  @if($maquinaria->precio_dia)
                    <span class="price font-weight-bold text-success">Bs {{ number_format($maquinaria->precio_dia, 2) }}/día</span>
                  @else
                    <span class="price font-weight-bold text-muted">Precio a consultar</span>
                  @endif
                  <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="btn btn-success btn-sm px-3">
                    Ver Anuncio <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
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
              <div class="card h-100 shadow-sm rounded-lg card-ad border-0">
                <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-leaf fa-5x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title mb-2">{{ $organico->nombre }}</h5>
                  <ul class="ad-meta list-unstyled mb-2">
                    @if($organico->fecha_cosecha)
                      <li><i class="fas fa-calendar text-muted"></i> Cosecha: {{ \Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y') }}</li>
                    @endif
                    @if($organico->stock)
                      <li><i class="fas fa-box text-muted"></i> Stock: {{ $organico->stock }}</li>
                    @endif
                  </ul>
                  <span class="badge badge-success badge-pill px-3">
                    {{ $organico->categoria->nombre ?? 'Orgánico' }}
                  </span>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top">
                  @if($organico->precio)
                    <span class="price font-weight-bold text-success">Bs {{ number_format($organico->precio, 2) }}</span>
                  @else
                    <span class="price font-weight-bold text-muted">Precio a consultar</span>
                  @endif
                  <a href="{{ route('organicos.show', $organico->id) }}" class="btn btn-success btn-sm px-3">
                    Ver Anuncio <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
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
