<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title">Tipos de Animales</h3>

        <form method="get" class="form-inline ml-auto">
            <input type="text" name="q" class="form-control form-control-sm mr-2" placeholder="Buscar..." value="<?php echo e($q); ?>">
            <button class="btn btn-sm btn-primary">Buscar</button>
        </form>

        <a href="<?php echo e(route('tipo_animals.create')); ?>" class="btn btn-sm btn-success ml-2">Nuevo</a>
    </div>

    <div class="card-body p-0">
        <?php if(session('ok')): ?>
        <div class="alert alert-success m-3"><?php echo e(session('ok')); ?></div>
        <?php endif; ?>

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-right pr-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i->id); ?></td>
                    <td><?php echo e($i->nombre); ?></td>
                    <td><?php echo e($i->descripcion); ?></td>
                    <td class="text-right pr-3">
                        <a href="<?php echo e(route('tipo_animals.edit', $i)); ?>" class="btn btn-sm btn-primary">Editar</a>
                        <form action="<?php echo e(route('tipo_animals.destroy', $i)); ?>" method="post" class="d-inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <?php echo e($items->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy\proyecto-sistem\resources\views/tipo_animals/index.blade.php ENDPATH**/ ?>