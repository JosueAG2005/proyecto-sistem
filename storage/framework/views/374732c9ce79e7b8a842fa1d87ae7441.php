<?php $__env->startSection('title','Orgánicos'); ?>
<?php $__env->startSection('page_title','Orgánicos'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title mb-0 mr-auto">Listado</h3>

    <form method="get" class="form-inline">
      <div class="input-group input-group-sm mr-2">
        <input type="text" name="q" value="<?php echo e($q ?? ''); ?>" class="form-control" placeholder="Buscar...">
        <div class="input-group-append">
          <button class="btn btn-primary">Buscar</button>
        </div>
      </div>
    </form>

    <a href="<?php echo e(route('organicos.create')); ?>" class="btn btn-success btn-sm mr-2">Nuevo</a>
    <a href="<?php echo e(route('maquinarias.index')); ?>" class="btn btn-info btn-sm">Ir a Maquinarias</a>
  </div>

  <div class="card-body p-0">
    <?php if(session('ok')): ?>
      <div class="alert alert-success m-3"><?php echo e(session('ok')); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th class="text-right pr-3">Acciones</th>
          </tr>
        </thead>

        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $organicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($o->id); ?></td>

            <td>
                <a href="<?php echo e(route('organicos.show', $o)); ?>">
                    <?php echo e($o->nombre); ?>

                </a>
            </td>

            
            <td><?php echo e($o->categoria->nombre ?? 'Sin categoría'); ?></td>

            <td><?php echo e(number_format($o->precio, 2)); ?></td>
            <td><?php echo e($o->stock); ?></td>

            <td class="text-right pr-3">
              <a href="<?php echo e(route('organicos.edit', $o)); ?>" class="btn btn-sm btn-primary">Editar</a>

              <form action="<?php echo e(route('organicos.destroy', $o)); ?>" method="post" class="d-inline">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="6" class="text-center text-muted">Sin registros</td>
          </tr>
        <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>

  <div class="card-footer">
    <?php echo e($organicos->appends(['q' => $q ?? null])->links()); ?>

  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/organicos/index.blade.php ENDPATH**/ ?>