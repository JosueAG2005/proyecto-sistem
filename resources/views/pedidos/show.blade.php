@extends('layouts.adminlte')

@section('title', 'Detalle de Pedido')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="fas fa-receipt"></i> Pedido #{{ $pedido->id }}
        </h1>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Información general
                    </h3>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $pedido->id }}</p>
                    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}</p>
                    <p><strong>Usuario:</strong> {{ $pedido->user->name ?? '—' }}</p>
                    <p><strong>Email:</strong> {{ $pedido->user->email ?? '—' }}</p>
                    <p><strong>Estado:</strong>
                        @if($pedido->estado == 'pendiente')
                            <span class="badge badge-warning">
                                <i class="fas fa-clock"></i> Pendiente
                            </span>
                        @elseif($pedido->estado == 'pagado')
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Pagado
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times"></i> Cancelado
                            </span>
                        @endif
                    </p>
                    <p><strong>Total:</strong> {{ number_format($pedido->total, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-list"></i> Detalle del pedido
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Producto orgánico</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedido->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->organico->nombre ?? '—' }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td>{{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Este pedido no tiene detalle registrado.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
