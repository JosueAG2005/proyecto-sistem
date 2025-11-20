<?php $__env->startSection('title','Datos Sanitarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Datos Sanitarios</h1>
        <a href="<?php echo e(route('datos-sanitarios.create')); ?>" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Nuevo Registro
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-striped mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Animal</th>
                        <th>Vacuna</th>
                        <th>Tratamiento</th>
                        <th>Fecha Aplicación</th>
                        <th>Próxima Fecha</th>
                        <th style="width:140px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->id); ?></td>
                        <td><?php echo e($item->ganado->nombre); ?></td>
                        <td><?php echo e($item->vacuna ?? '—'); ?></td>
                        <td><?php echo e($item->tratamiento ?? '—'); ?></td>
                        <td><?php echo e($item->fecha_aplicacion ?? '—'); ?></td>
                        <td><?php echo e($item->proxima_fecha ?? '—'); ?></td>

                        <td>
                            <a href="<?php echo e(route('datos-sanitarios.edit',$item->id)); ?>"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="<?php echo e(route('datos-sanitarios.destroy',$item->id)); ?>"
                                method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar registro?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy\proyecto-sistem\resources\views/datos_sanitarios/index.blade.php ENDPATH**/ ?>