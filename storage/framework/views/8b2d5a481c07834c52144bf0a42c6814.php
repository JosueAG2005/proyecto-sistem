<?php $__env->startSection('content'); ?>
<div class="x_panel">
  <div class="x_title">
    <h2>Categorías</h2>
    <div class="clearfix"></div>
  </div>

  <div class="x_content">
    <div class="row mb-3">
      <div class="col-md-4">
        <form action="<?php echo e(route('categorias.index')); ?>" method="GET">
          <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="<?php echo e(request('buscar')); ?>">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit">Buscar</button>
            </span>
          </div>
        </form>
      </div>
      <div class="col-md-8 text-right">
        <a href="<?php echo e(route('categorias.create')); ?>" class="btn btn-success">Nueva</a>
        <a href="<?php echo e(route('organicos.index')); ?>" class="btn btn-info">Ir a Orgánicos</a>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($categoria->id); ?></td>
            <td><?php echo e($categoria->nombre); ?></td>
            <td><?php echo e($categoria->descripcion); ?></td>
            <td>
              <a href="<?php echo e(route('categorias.edit', $categoria)); ?>" class="btn btn-primary btn-sm">Editar</a>
              <form action="<?php echo e(route('categorias.destroy', $categoria)); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar esta categoría?')">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="4" class="text-center">Sin registros</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy\proyecto-sistem\resources\views/categorias/index.blade.php ENDPATH**/ ?>