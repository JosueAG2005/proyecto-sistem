

<?php $__env->startSection('title', 'Detalle de Pedido'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="fas fa-receipt"></i> Pedido #<?php echo e($pedido->id); ?>

        </h1>
        <a href="<?php echo e(route('admin.pedidos.index')); ?>" class="btn btn-secondary btn-sm">
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
                    <p><strong>ID:</strong> <?php echo e($pedido->id); ?></p>
                    <p><strong>Fecha:</strong> <?php echo e(\Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i')); ?></p>
                    <p><strong>Usuario:</strong> <?php echo e($pedido->user->name ?? '—'); ?></p>
                    <p><strong>Email:</strong> <?php echo e($pedido->user->email ?? '—'); ?></p>
                    <p><strong>Estado:</strong>
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
                    </p>
                    <p><strong>Total:</strong> <?php echo e(number_format($pedido->total, 2)); ?></p>
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
                            <?php $__empty_1 = true; $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($detalle->organico->nombre ?? '—'); ?></td>
                                    <td><?php echo e($detalle->cantidad); ?></td>
                                    <td><?php echo e(number_format($detalle->precio_unitario, 2)); ?></td>
                                    <td><?php echo e(number_format($detalle->subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Este pedido no tiene detalle registrado.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy\proyecto-sistem\resources\views/pedidos/show.blade.php ENDPATH**/ ?>