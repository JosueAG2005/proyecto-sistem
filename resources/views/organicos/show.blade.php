@extends('layouts.adminlte')

@section('title', 'Detalle de Orgánico')

@section('content')
<div class="container-fluid">

    <style>
        .panel-info-card {
            height: 430px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .panel-equal-card {
            height: 280px; 
        }

        @media (max-width: 992px) {
            .panel-info-card,
            .panel-equal-card {
                height: auto !important;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-leaf text-success"></i> Detalle de Orgánico
            </h1>
            <p class="text-muted mb-0">Información completa del producto</p>
        </div>

        <a href="{{ route('organicos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-0">

                    <div class="position-relative bg-white d-flex justify-content-center align-items-center" 
                         style="height: 430px; border-radius: 8px;">
                        
                        @if($organico->imagenes->count())
                            <img id="mainImage" 
                                 src="{{ asset('storage/'.$organico->imagenes->first()->ruta) }}"
                                 style="max-height:100%; max-width:100%; object-fit:contain; cursor:pointer;"
                                 data-toggle="modal" 
                                 data-target="#imageModal"
                                 onclick="document.getElementById('imageModalImg').src = this.src">
                        @else
                            <img src="{{ asset('img/organico-placeholder.jpg') }}"
                                 style="max-height:100%; max-width:100%; object-fit:contain;">
                        @endif

                        <span class="badge badge-success position-absolute" style="top:10px; right:10px;">
                            <i class="fas fa-image"></i> Click para ampliar
                        </span>
                    </div>

                </div>
            </div>

            @if($organico->imagenes->count() > 1)
                <div class="row">
                    @foreach($organico->imagenes as $img)
                        <div class="col-4 mb-2">
                            <div class="bg-white border rounded d-flex align-items-center justify-content-center"
                                 style="height:90px; cursor:pointer;"
                                 onclick="document.getElementById('mainImage').src = this.querySelector('img').src">

                                <img src="{{ asset('storage/'.$img->ruta) }}"
                                     style="max-height:100%; max-width:100%; object-fit:contain;">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- INFO PRINCIPAL -->
        <div class="col-lg-6">

            <div class="card shadow-sm border-0 mb-4 panel-info-card">
                <div class="card-body">

                    <h2 class="h4 text-dark mb-3">{{ $organico->nombre }}</h2>

                    <div class="mb-3">
                        @if($organico->categoria)
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-tag"></i> {{ $organico->categoria->nombre }}
                            </span>
                        @endif

                        @if($organico->unidad)
                            <span class="badge badge-info px-3 py-2">
                                <i class="fas fa-balance-scale"></i> {{ $organico->unidad->nombre }}
                            </span>
                        @endif
                    </div>

                    <div class="p-3 mb-3 rounded" style="background:#e8f5e9;">
                        <small class="text-muted d-block mb-1">Precio</small>
                        <h3 class="h4 text-success font-weight-bold">
                            Bs {{ number_format($organico->precio, 2) }}
                        </h3>
                    </div>

        @auth
            @if($organico->precio && ($organico->stock ?? 0) > 0)
                <div class="border-top pt-3 mt-3">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_type" value="organico">
                        <input type="hidden" name="product_id" value="{{ $organico->id }}">

                        <div class="form-row align-items-end">
                            <div class="col-auto">
                                <label class="small font-weight-bold text-muted mb-1 d-block">
                                    Cantidad
                                </label>
                                <input type="number"
                                       name="cantidad"
                                       class="form-control"
                                       value="1"
                                       min="1"
                                       max="{{ $organico->stock ?? 1 }}"
                                       required
                                       style="width: 100px;">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-cart-plus"></i> Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @elseif(($organico->stock ?? 0) <= 0)
                <div class="alert alert-warning mt-3 mb-0">
                    <small><i class="fas fa-exclamation-triangle"></i> Sin stock disponible</small>
                </div>
            @endif
        @else
            <div class="mt-3 pt-2 border-top">
                <a href="{{ route('login') }}" class="btn btn-outline-success btn-block">
                    <i class="fas fa-sign-in-alt"></i> Inicia sesión para comprar
                </a>
            </div>
        @endauth


                </div>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0 mb-4 panel-equal-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary"></i> Información Detallada
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-calendar-alt fa-2x text-primary mr-3"></i>
                                <div>
                                    <small class="text-muted">Fecha de Cosecha</small>
                                    <div class="font-weight-bold">
                                        {{ $organico->fecha_cosecha 
                                            ? \Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y') 
                                            : '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-clipboard-check fa-2x text-success mr-3"></i>
                                <div>
                                    <small class="text-muted">Stock</small>
                                    <div class="font-weight-bold">{{ $organico->stock }} unidades</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-align-left"></i> Descripción
                        </h6>
                        <p class="text-dark">
                            {{ $organico->descripcion ?: 'Sin descripción' }}
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4 panel-equal-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt text-danger"></i> Ubicación
                    </h5>
                </div>

                <div class="card-body">

                    <p class="mb-2">
                        @if($organico->origen)
                            {{ $organico->origen }}
                        @elseif($organico->latitud_origen && $organico->longitud_origen)
                            Lat: {{ $organico->latitud_origen }}, Lng: {{ $organico->longitud_origen }}
                        @else
                            <span class="text-muted">No registrada</span>
                        @endif
                    </p>

                    @if($organico->latitud_origen && $organico->longitud_origen)
                        <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#mapModal">
                            <i class="fas fa-map"></i> Ver Mapa
                        </button>
                    @endif

                </div>
            </div>

        </div>

    </div>

</div>

@if($organico->latitud_origen && $organico->longitud_origen)
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación del Producto
                </h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-0">
                <div id="map-organico" style="height:500px; width:100%;"></div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map;

$('#mapModal').on('shown.bs.modal', function () {
    if (!map) {
        map = L.map('map-organico').setView(
            [{{ $organico->latitud_origen }}, {{ $organico->longitud_origen }}],
            16
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
        { maxZoom: 19 }).addTo(map);

        L.marker([{{ $organico->latitud_origen }}, {{ $organico->longitud_origen }}])
            .addTo(map)
            .bindPopup("{{ $organico->nombre }}");
    } else {
        map.invalidateSize();
    }
});
</script>
@endif

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">

            <button type="button" class="close text-white ml-auto mr-2 mt-2" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-body p-0 text-center">
                <img id="imageModalImg" src="" class="img-fluid rounded"
                     style="max-height: 80vh; object-fit: contain;">
            </div>

        </div>
    </div>
</div>

@endsection
