

<?php $__env->startSection('title', 'Pedidos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="fas fa-receipt"></i> Pedidos
        </h1>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <form method="GET" action="<?php echo e(route('admin.pedidos.index')); ?>" class="d-inline">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <select name="estado" class="form-control" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>Pendientes</option>
                            <option value="pagado" <?php echo e(request('estado') == 'pagado' ? 'selected' : ''); ?>>Pagados</option>
                            <option value="cancelado" <?php echo e(request('estado') == 'cancelado' ? 'selected' : ''); ?>>Cancelados</option>
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
                    <?php $__empty_1 = true; $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($pedido->id); ?></td>
                            <td>
                                <small><?php echo e(\Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i')); ?></small>
                            </td>
                            <td><?php echo e($pedido->user->name ?? '—'); ?></td>
                            <td><?php echo e($pedido->user->email ?? '—'); ?></td>
                            <td>
                                <?php if($pedido->estado == 'pendiente'): ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                <?php elseif($pedido->estado == 'pagado'): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Pagado
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Cancelado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(number_format($pedido->total, 2)); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.pedidos.show', $pedido)); ?>" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No hay pedidos registrados.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <?php echo e($pedidos->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy\proyecto-sistem\resources\views/pedidos/index.blade.php ENDPATH**/ ?>