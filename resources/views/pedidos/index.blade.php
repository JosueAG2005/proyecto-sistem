@extends('layouts.adminlte')

<<<<<<< HEAD
@section('title', 'Mis Pedidos')
@section('page_title', 'Mis Pedidos')

@section('content')
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-receipt mr-2"></i>Mis Pedidos</h3>
    </div>
    <div class="card-body">
      @if($pedidos->count())
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          @foreach($pedidos as $pedido)
            <tr>
              <td>{{ $pedido->id }}</td>
              <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
              <td>Bs {{ number_format($pedido->total, 2) }}</td>
              <td><span class="badge badge-info text-uppercase">{{ $pedido->estado }}</span></td>
              <td>
                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye mr-1"></i>Ver
                </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>

        {{ $pedidos->links() }}
      @else
        <p class="text-muted mb-0">Aún no tienes pedidos.</p>
      @endif
    </div>
  </div>
=======
@section('title', 'Pedidos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="fas fa-receipt"></i> Pedidos
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <form method="GET" action="{{ route('admin.pedidos.index') }}" class="d-inline">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <select name="estado" class="form-control" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                            <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagados</option>
                            <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelados</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>{{ $pedido->user->name ?? '—' }}</td>
                            <td>{{ $pedido->user->email ?? '—' }}</td>
                            <td>
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
                            </td>
                            <td>{{ number_format($pedido->total, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.pedidos.show', $pedido) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No hay pedidos registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $pedidos->links() }}
        </div>
    </div>
>>>>>>> 89fbe6a12fc20e76dae4ad5480f6d14c87d0ca7e
</div>
@endsection
