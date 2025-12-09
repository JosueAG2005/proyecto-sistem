<?php $__env->startSection('title', 'Detalle de Maquinaria'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <style>
        :root {
            --primary-color: #ffc107;
            --primary-dark: #ff9800;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --dark-color: #343a40;
        }

        /* Eliminar espacio blanco superior */
        .content-header {
            display: none !important;
        }

        .content-wrapper {
            padding-top: 0 !important;
        }

        .content {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            padding-top: 0.5rem;
            padding-bottom: 1.5rem;
            margin-top: 0;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            margin-top: 0;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            color: white;
        }

        .page-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 1.75rem;
        }

        .card {
            margin-bottom: 1.5rem !important;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-bottom: 2px solid rgba(0,0,0,0.05);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .card-header.bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-header.bg-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .card-header.bg-warning {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: #333;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-body .row {
            margin-left: -0.75rem;
            margin-right: -0.75rem;
        }

        .card-body .row > [class*="col-"] {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .badge-lg {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .bg-success-light {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
        }

        .bg-warning-light {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
        }

        .info-icon {
            font-size: 1.75rem !important;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            margin-right: 1rem;
        }

        .info-row-item {
            margin-bottom: 1.25rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .info-row-item:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .info-row-item:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .info-value {
            font-size: 1rem;
            line-height: 1.5;
            font-weight: 500;
            color: #212529;
        }

        /* Galería de imágenes mejorada */
        .image-gallery {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .main-image-container {
            height: 450px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .main-image-container img:hover {
            transform: scale(1.05);
        }

        .thumbnail-container {
            padding: 0.75rem;
            background: #f8f9fa;
        }

        .thumbnail-item {
            height: 90px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
            background: white;
        }

        .thumbnail-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        .thumbnail-item.active {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.3);
        }

        /* Panel de precio mejorado */
        .price-panel {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-left: 5px solid var(--primary-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }

        .price-display {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            padding: 1.25rem;
            color: #333;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        .price-display h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.75rem;
        }

        .price-display small {
            font-size: 0.85rem;
            opacity: 0.8;
            font-weight: 500;
        }

        /* Badges mejorados */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.85rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Botones mejorados */
        .btn-modern {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        /* Información del vendedor */
        .seller-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: 3px solid var(--primary-color);
            border-radius: 12px;
        }

        .seller-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: #333;
            padding: 1rem 1.5rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .card-body {
                padding: 1rem;
            }
            .info-icon {
                font-size: 1.5rem !important;
                width: 45px;
                height: 45px;
            }
            .main-image-container {
                height: 300px;
            }
        }
    </style>

    <!-- Header Mejorado -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-1">
                    <i class="fas fa-tractor mr-2"></i> Detalle de Maquinaria
                </h1>
                <p class="mb-0 opacity-90" style="font-size: 0.95rem;">Información completa del equipo</p>
            </div>
            <a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('maquinarias.index')); ?>" 
               class="btn btn-light btn-modern">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Galería y Contenido Principal -->
        <div class="col-lg-8">
            <!-- Galería de Imágenes Mejorada -->
            <div class="card image-gallery mb-4">
                <?php if($maquinaria->imagenes && $maquinaria->imagenes->count() > 0): ?>
                    <div class="main-image-container">
                        <img id="imagen-principal" 
                             src="<?php echo e(asset('storage/'.$maquinaria->imagenes->first()->ruta)); ?>" 
                             alt="<?php echo e($maquinaria->nombre); ?>" 
                             data-toggle="modal"
                             data-target="#imageModal"
                             onclick="document.getElementById('imageModalImg').src = this.src"
                             title="Click para ver imagen completa">
                        <div class="position-absolute" style="top:15px; right:15px;">
                            <span class="badge badge-success badge-modern">
                                <i class="fas fa-expand-arrows-alt mr-1"></i> Click para ampliar
                            </span>
                        </div>
                    </div>
                    
                    <?php if($maquinaria->imagenes->count() > 1): ?>
                        <div class="thumbnail-container">
                            <div class="row no-gutters">
                                <?php $__currentLoopData = $maquinaria->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-4 pr-2">
                                        <div class="thumbnail-item <?php echo e($loop->first ? 'active' : ''); ?>" 
                                             onclick="
                                                document.getElementById('imagen-principal').src = '<?php echo e(asset('storage/'.$imagen->ruta)); ?>';
                                                document.getElementById('imageModalImg').src = '<?php echo e(asset('storage/'.$imagen->ruta)); ?>';
                                                document.querySelectorAll('.thumbnail-item').forEach(el => el.classList.remove('active'));
                                                this.classList.add('active');
                                             ">
                                            <img src="<?php echo e(asset('storage/'.$imagen->ruta)); ?>" 
                                                 alt="Imagen <?php echo e($loop->iteration); ?>" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="main-image-container">
                        <div class="text-center text-muted">
                            <i class="fas fa-image fa-5x mb-3" style="opacity: 0.3;"></i>
                            <p class="mb-0" style="font-size: 1.1rem;">Sin imágenes disponibles</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Información Básica Mejorada -->
            <div class="card mb-4">
                <div class="card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="fas fa-tractor mr-2"></i> Información Básica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if($maquinaria->tipoMaquinaria): ?>
                            <div class="col-md-6 info-row-item">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon text-primary">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Tipo de Maquinaria</small>
                                        <strong class="d-block info-value"><?php echo e($maquinaria->tipoMaquinaria->nombre); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($maquinaria->marcaMaquinaria): ?>
                            <div class="col-md-6 info-row-item">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon text-info">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Marca</small>
                                        <strong class="d-block info-value"><?php echo e($maquinaria->marcaMaquinaria->nombre); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($maquinaria->modelo): ?>
                            <div class="col-md-6 info-row-item">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon text-warning">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Modelo</small>
                                        <strong class="d-block info-value"><?php echo e($maquinaria->modelo); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($maquinaria->estadoMaquinaria): ?>
                            <div class="col-md-6 info-row-item">
                                <div class="d-flex align-items-center">
                                    <?php
                                        $estadoNombre = strtolower(str_replace(' ', '_', $maquinaria->estadoMaquinaria->nombre));
                                        $iconColor = 'text-success';
                                        if($estadoNombre === 'en_mantenimiento') $iconColor = 'text-warning';
                                        elseif($estadoNombre === 'dado_baja') $iconColor = 'text-danger';
                                        elseif($estadoNombre === 'en_uso') $iconColor = 'text-info';
                                    ?>
                                    <div class="info-icon <?php echo e($iconColor); ?>">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Estado</small>
                                        <strong class="d-block info-value"><?php echo e($maquinaria->estadoMaquinaria->nombre); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($maquinaria->telefono): ?>
                            <div class="col-md-6 info-row-item">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon text-success">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Teléfono de Contacto</small>
                                        <strong class="d-block info-value">
                                            <a href="tel:<?php echo e($maquinaria->telefono); ?>" class="text-dark text-decoration-none">
                                                <i class="fas fa-phone-alt mr-1"></i><?php echo e($maquinaria->telefono); ?>

                                            </a>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($maquinaria->categoria): ?>
                            <div class="col-md-6 info-row-item">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon text-info">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Categoría</small>
                                        <strong class="d-block info-value"><?php echo e($maquinaria->categoria->nombre); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($maquinaria->descripcion): ?>
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-start">
                                <div class="info-icon text-primary mr-3">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-2 section-title">Descripción</small>
                                    <p class="mb-0 info-value" style="line-height: 1.7;"><?php echo e($maquinaria->descripcion); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ubicación Mejorada -->
            <div class="card mb-4">
                <div class="card-header bg-danger">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt mr-2"></i> Ubicación
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($maquinaria->ciudad || $maquinaria->municipio || $maquinaria->departamento): ?>
                        <div class="info-row-item">
                            <div class="d-flex align-items-center">
                                <div class="info-icon text-danger">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0 section-title">Ciudad</small>
                                    <strong class="d-block info-value"><?php echo e($maquinaria->ciudad ?? $maquinaria->municipio ?? 'No disponible'); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="info-row-item">
                            <small class="text-muted d-block mb-1 section-title">Dirección Completa</small>
                            <?php
                                $direccion = [];
                                if($maquinaria->municipio) $direccion[] = $maquinaria->municipio;
                                if($maquinaria->provincia) $direccion[] = 'Provincia ' . $maquinaria->provincia;
                                if($maquinaria->departamento) $direccion[] = $maquinaria->departamento;
                                $direccion[] = 'Bolivia';
                                $direccionCompleta = implode(', ', $direccion);
                            ?>
                            <strong class="info-value">
                                <i class="fas fa-map-marker-alt text-danger mr-1"></i><?php echo e($direccionCompleta); ?>

                            </strong>
                        </div>
                    <?php elseif($maquinaria->ubicacion): ?>
                        <div class="info-row-item">
                            <div class="d-flex align-items-center">
                                <div class="info-icon text-danger">
                                    <i class="fas fa-location-dot"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong class="info-value"><?php echo e($maquinaria->ubicacion); ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0 info-value text-center py-3">
                            <i class="fas fa-map-marker-alt mr-2"></i>Sin ubicación especificada
                        </p>
                    <?php endif; ?>
                    <?php if($maquinaria->latitud && $maquinaria->longitud): ?>
                        <div class="mt-3">
                            <button type="button" class="btn btn-danger btn-modern btn-block" data-toggle="modal" data-target="#mapModal">
                                <i class="fas fa-map mr-2"></i> Ver Mapa Interactivo
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Panel de Precio/Carrito, Fechas, Vendedor -->
        <div class="col-lg-4">
            <!-- Panel de Precio y Carrito Mejorado -->
            <div class="price-panel mb-4">
                <h2 class="h4 mb-3 text-dark font-weight-bold"><?php echo e($maquinaria->nombre); ?></h2>
                
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <?php if($maquinaria->categoria): ?>
                        <span class="badge badge-success badge-modern">
                            <i class="fas fa-tag mr-1"></i> <?php echo e($maquinaria->categoria->nombre); ?>

                        </span>
                    <?php endif; ?>
                    <?php if($maquinaria->tipoMaquinaria): ?>
                        <span class="badge badge-warning badge-modern">
                            <i class="fas fa-cog mr-1"></i> <?php echo e($maquinaria->tipoMaquinaria->nombre); ?>

                        </span>
                    <?php endif; ?>
                    <?php if($maquinaria->estadoMaquinaria): ?>
                        <?php
                            $estadoNombre = strtolower(str_replace(' ', '_', $maquinaria->estadoMaquinaria->nombre));
                            $badgeClass = 'badge-secondary';
                            if($estadoNombre === 'disponible') $badgeClass = 'badge-success';
                            elseif($estadoNombre === 'en_mantenimiento') $badgeClass = 'badge-warning';
                            elseif($estadoNombre === 'dado_baja') $badgeClass = 'badge-danger';
                            elseif($estadoNombre === 'en_uso') $badgeClass = 'badge-info';
                        ?>
                        <span class="badge <?php echo e($badgeClass); ?> badge-modern">
                            <i class="fas fa-check-circle mr-1"></i> <?php echo e($maquinaria->estadoMaquinaria->nombre); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <?php if($maquinaria->precio_dia): ?>
                    <div class="price-display">
                        <small class="d-block mb-2">Precio por día</small>
                        <h3 class="mb-0">
                            <i class="fas fa-boliviano-sign mr-1"></i><?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día
                        </h3>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-3 py-3 text-center">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0"><strong>Precio a consultar</strong></p>
                    </div>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <?php if($maquinaria->precio_dia && $maquinaria->estadoMaquinaria && strtolower(str_replace(' ', '_', $maquinaria->estadoMaquinaria->nombre)) === 'disponible'): ?>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_type" value="maquinaria">
                            <input type="hidden" name="product_id" value="<?php echo e($maquinaria->id); ?>">
                            <div class="mb-3">
                                <label class="small font-weight-bold text-muted mb-2 d-block">
                                    <i class="fas fa-calendar-day mr-1"></i> Días de alquiler
                                </label>
                                <input type="number" 
                                       name="dias_alquiler" 
                                       class="form-control form-control-lg" 
                                       value="1" 
                                       min="1" 
                                       required
                                       style="border-radius: 8px; border: 2px solid #e0e0e0;">
                            </div>
                            <button type="submit" class="btn btn-success btn-modern btn-block">
                                <i class="fas fa-cart-plus mr-2"></i> Agregar al Carrito
                            </button>
                        </form>
                    <?php elseif($maquinaria->estadoMaquinaria && strtolower(str_replace(' ', '_', $maquinaria->estadoMaquinaria->nombre)) !== 'disponible'): ?>
                        <div class="alert alert-warning mb-0 py-3 text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p class="mb-0"><strong>No disponible para alquiler</strong></p>
                            <small>Estado: <?php echo e($maquinaria->estadoMaquinaria->nombre); ?></small>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="mt-3 pt-3 border-top">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-success btn-modern btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i> Inicia sesión para alquilar
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Fechas Mejorado -->
            <div class="card mb-4">
                <div class="card-header bg-primary">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt mr-2"></i> Fechas
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($maquinaria->created_at): ?>
                        <div class="info-row-item">
                            <div class="d-flex align-items-center">
                                <div class="info-icon text-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0 section-title">Fecha de Publicación</small>
                                    <strong class="info-value"><?php echo e(\Carbon\Carbon::parse($maquinaria->created_at)->format('d/m/Y')); ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0 info-value text-center">Sin fecha de publicación</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información del Vendedor Mejorada -->
            <?php if($maquinaria->user): ?>
            <div class="card seller-card mb-4">
                <div class="seller-header">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-user mr-2"></i> Información del Vendedor
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-row-item mb-3">
                        <h6 class="mb-2 font-weight-bold text-dark" style="font-size: 1.1rem;"><?php echo e($maquinaria->user->name); ?></h6>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-warning mr-2"></i>
                            <small class="text-muted info-value"><?php echo e($maquinaria->user->email); ?></small>
                        </div>
                    </div>
                    
                    <div class="border-top pt-3">
                        <?php if($maquinaria->user->role): ?>
                            <div class="info-row-item mb-3">
                                <small class="text-muted d-block mb-2 section-title">Tipo de Usuario</small>
                                <?php
                                    $roleName = $maquinaria->user->role->nombre ?? $maquinaria->user->role_name ?? 'Cliente';
                                    $badgeClass = 'badge-secondary';
                                    if($roleName === 'Administrador' || $roleName === 'admin') {
                                        $badgeClass = 'badge-danger';
                                    } elseif($roleName === 'Vendedor' || $roleName === 'vendedor') {
                                        $badgeClass = 'badge-success';
                                    }
                                ?>
                                <span class="badge <?php echo e($badgeClass); ?> badge-modern">
                                    <i class="fas fa-user-tag mr-1"></i> <?php echo e($roleName); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($maquinaria->user->created_at): ?>
                            <div class="info-row-item">
                                <div class="d-flex align-items-center">
                                    <div class="info-icon text-warning">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block mb-0 section-title">Miembro Desde</small>
                                        <strong class="info-value"><?php echo e(\Carbon\Carbon::parse($maquinaria->user->created_at)->format('d/m/Y')); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->id() !== $maquinaria->user_id): ?>
                            <div class="mt-3 pt-3 border-top">
                                <a href="mailto:<?php echo e($maquinaria->user->email); ?>" class="btn btn-warning btn-modern btn-block">
                                    <i class="fas fa-envelope mr-2"></i> Contactar Vendedor
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="mt-3 pt-3 border-top">
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-warning btn-modern btn-block">
                                <i class="fas fa-sign-in-alt mr-2"></i> Inicia sesión para contactar
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal del Mapa -->
<?php if($maquinaria->latitud && $maquinaria->longitud): ?>
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-map-marker-alt mr-2"></i> Ubicación del Anuncio
                </h5>
                <button class="close text-white" data-dismiss="modal" style="opacity: 0.8;">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div id="map-maquinaria-modal" style="height:500px; width:100%;"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-modern" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
window.addEventListener('load', function() {
    $(document).ready(function() {
        let mapMaquinaria = null;
        
        <?php
            $popupText = $maquinaria->nombre;
            if($maquinaria->ciudad || $maquinaria->municipio) {
                $popupText .= ' - ' . ($maquinaria->ciudad ?? $maquinaria->municipio);
            }
            if($maquinaria->municipio || $maquinaria->provincia || $maquinaria->departamento) {
                $direccion = [];
                if($maquinaria->municipio) $direccion[] = $maquinaria->municipio;
                if($maquinaria->provincia) $direccion[] = 'Provincia ' . $maquinaria->provincia;
                if($maquinaria->departamento) $direccion[] = $maquinaria->departamento;
                $direccion[] = 'Bolivia';
                $popupText .= ' - ' . implode(', ', $direccion);
            } elseif($maquinaria->ubicacion) {
                $popupText .= ' - ' . $maquinaria->ubicacion;
            }
        ?>

        function initMap() {
            if (typeof L === 'undefined') {
                console.error('Leaflet no está disponible');
                return false;
            }
            
            try {
                mapMaquinaria = L.map('map-maquinaria-modal').setView(
                    [<?php echo e($maquinaria->latitud); ?>, <?php echo e($maquinaria->longitud); ?>],
                    12
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapMaquinaria);

                L.marker([<?php echo e($maquinaria->latitud); ?>, <?php echo e($maquinaria->longitud); ?>])
                    .addTo(mapMaquinaria)
                    .bindPopup("<?php echo e(addslashes($popupText)); ?>");
                
                return true;
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
                return false;
            }
        }

        $('#mapModal').on('shown.bs.modal', function () {
            if (!mapMaquinaria) {
                setTimeout(function() {
                    if (!initMap()) {
                        setTimeout(initMap, 500);
                    }
                }, 200);
            } else {
                setTimeout(function() {
                    mapMaquinaria.invalidateSize();
                }, 100);
            }
        });
    });
});
</script>
<?php endif; ?>


<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <button type="button" class="close text-white ml-auto mr-3 mt-3" data-dismiss="modal" aria-label="Close" style="font-size: 2.5rem; z-index: 1051; opacity: 0.9; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0 text-center">
                <img id="imageModalImg" src="" class="img-fluid rounded shadow-lg"
                     style="max-height: 85vh; object-fit: contain; border-radius: 12px;">
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/maquinarias/show.blade.php ENDPATH**/ ?>