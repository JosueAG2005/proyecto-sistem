<?php $__env->startSection('title', 'Detalle de Ganado'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <style>
        .panel-info-card {
            height: auto;
        }
        .badge-lg {
            font-size: 0.85rem;
            padding: 0.4rem 0.6rem;
        }
        .bg-success-light {
            background-color: #d4edda !important;
        }
        .card {
            margin-bottom: 0.75rem !important;
        }
        .compact-row {
            margin-bottom: 0.5rem;
        }
        .compact-row:last-child {
            margin-bottom: 0;
        }
        .section-divider {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #dee2e6;
        }
        .info-item {
            margin-bottom: 0.5rem;
        }
        .info-item:last-child {
            margin-bottom: 0;
        }
        .img-preview-inline {
            display: inline-block;
            vertical-align: middle;
            margin-left: 0.5rem;
        }
        .btn-inline-img {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="h4 mb-0 text-dark">
                <i class="fas fa-cow text-success"></i> Detalle del Ganado
            </h1>
        </div>
        <a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('ganados.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <!-- Galería de Imágenes -->
        <div class="col-lg-5 mb-3">
            <?php if($ganado->imagenes && $ganado->imagenes->count() > 0): ?>
                <div class="card shadow-sm border-0 mb-2">
                    <div class="card-body p-0">
                        <div class="position-relative bg-white d-flex justify-content-center align-items-center" 
                             style="height: 320px; border-radius: 8px;">
                            <img id="imagen-principal" 
                                 src="<?php echo e(asset('storage/'.$ganado->imagenes->first()->ruta)); ?>" 
                                 alt="<?php echo e($ganado->nombre); ?>" 
                                 style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: pointer;"
                                 data-toggle="modal"
                                 data-target="#imageModal"
                                 onclick="document.getElementById('imageModalImg').src = this.src"
                                 title="Click para ver imagen completa">
                            <div class="position-absolute" style="top:10px; right:10px;">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-image"></i> Click para ampliar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if($ganado->imagenes->count() > 1): ?>
                    <div class="row no-gutters">
                        <?php $__currentLoopData = $ganado->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-4 pr-1">
                                <div class="bg-white border rounded d-flex align-items-center justify-content-center" 
                                     style="height: 65px; cursor: pointer; transition: all 0.2s;"
                                     onclick="
                                        document.getElementById('imagen-principal').src = '<?php echo e(asset('storage/'.$imagen->ruta)); ?>';
                                        document.getElementById('imageModalImg').src = '<?php echo e(asset('storage/'.$imagen->ruta)); ?>';
                                     "
                                     onmouseover="this.style.borderColor='#28a745'; this.style.transform='scale(1.05)'" 
                                     onmouseout="this.style.borderColor='#dee2e6'; this.style.transform='scale(1)'">
                                    <img src="<?php echo e(asset('storage/'.$imagen->ruta)); ?>" 
                                         alt="Imagen <?php echo e($loop->iteration); ?>" 
                                         style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php elseif($ganado->imagen): ?>
                <!-- Compatibilidad con imagen antigua -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="position-relative bg-white d-flex justify-content-center align-items-center" 
                             style="height: 320px; border-radius: 8px;">
                            <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                                 alt="Imagen de <?php echo e($ganado->nombre); ?>" 
                                 style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: pointer;"
                                 onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                                 title="Click para ver imagen completa">
                            <div class="position-absolute" style="top:10px; right:10px;">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-image"></i> Click para ampliar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 320px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-4x mb-3"></i>
                                <p class="mb-0">Sin imágenes disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Información Principal -->
        <div class="col-lg-7">
            <!-- Título y Precio -->
            <div class="card shadow-sm border-0 mb-2 panel-info-card">
                <div class="card-body p-2">
                    <h2 class="h5 mb-1 text-dark"><?php echo e($ganado->nombre); ?></h2>
                    
                    <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
                        <span class="badge badge-success badge-lg px-2 py-1">
                            <i class="fas fa-tag"></i> <?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?>

                        </span>
                        <?php if($ganado->tipoAnimal): ?>
                            <span class="badge badge-info badge-lg px-2 py-1">
                                <i class="fas fa-paw"></i> <?php echo e($ganado->tipoAnimal->nombre); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($ganado->stock ?? 0 > 0): ?>
                            <span class="badge badge-primary badge-lg px-2 py-1">
                                <i class="fas fa-box"></i> Stock: <?php echo e($ganado->stock); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($ganado->precio): ?>
                        <div class="bg-success-light p-2 rounded mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block mb-0">Precio</small>
                                    <h3 class="h5 mb-0 text-success font-weight-bold">
                                        Bs <?php echo e(number_format($ganado->precio, 2)); ?>

                                    </h3>
                                </div>
                                <div class="text-right">
                                    <i class="fas fa-money-bill-wave fa-lg text-success opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-2 py-1 px-2">
                            <i class="fas fa-info-circle"></i> <small>Precio a consultar</small>
                        </div>
                    <?php endif; ?>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if($ganado->precio && ($ganado->stock ?? 0) > 0): ?>
                            <div class="border-top pt-2 mt-2">
                                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_type" value="ganado">
                                    <input type="hidden" name="product_id" value="<?php echo e($ganado->id); ?>">
                                    <div class="form-row align-items-end">
                                        <div class="col-auto">
                                            <label class="small font-weight-bold text-muted mb-0 d-block">Cantidad</label>
                                            <input type="number" 
                                                   name="cantidad" 
                                                   class="form-control form-control-sm" 
                                                   value="1" 
                                                   min="1" 
                                                   max="<?php echo e($ganado->stock ?? 1); ?>" 
                                                   required
                                                   style="width: 80px;">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                                <i class="fas fa-cart-plus"></i> Agregar al Carrito
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Detallada -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-2">
                <div class="card-header bg-white border-bottom py-1 px-2">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-info-circle text-primary"></i> Información Detallada
                    </h5>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-6 mb-1 info-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-dna text-primary opacity-50 mr-2" style="width: 20px;"></i>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0">Raza</small>
                                    <strong class="d-block small"><?php echo e($ganado->raza->nombre ?? 'No especificada'); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1 info-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-birthday-cake text-warning opacity-50 mr-2" style="width: 20px;"></i>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0">Edad</small>
                                    <strong class="d-block small"><?php echo e($ganado->edad ?? '—'); ?> meses</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1 info-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-weight text-info opacity-50 mr-2" style="width: 20px;"></i>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0">Tipo de Peso</small>
                                    <strong class="d-block small"><?php echo e($ganado->tipoPeso->nombre ?? '—'); ?></strong>
                                </div>
                            </div>
                        </div>
                        <?php if($ganado->peso_actual): ?>
                        <div class="col-md-6 mb-1 info-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-weight-hanging text-success opacity-50 mr-2" style="width: 20px;"></i>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0">Peso Actual</small>
                                    <strong class="d-block small"><?php echo e(number_format($ganado->peso_actual, 2)); ?> kg</strong>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-6 mb-1 info-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-venus-mars text-danger opacity-50 mr-2" style="width: 20px;"></i>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block mb-0">Sexo</small>
                                    <strong class="d-block small"><?php echo e($ganado->sexo ?? '—'); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($ganado->descripcion): ?>
                        <div class="section-divider">
                            <h6 class="text-muted mb-1 small font-weight-bold">
                                <i class="fas fa-align-left"></i> Descripción
                            </h6>
                            <p class="mb-0 text-dark small"><?php echo e($ganado->descripcion); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($ganado->datoSanitario): ?>
                        <div class="section-divider">
                            <h6 class="text-muted mb-1 small font-weight-bold">
                                <i class="fas fa-syringe text-success"></i> Datos Sanitarios
                            </h6>
                            <div class="row">
                                <?php if($ganado->datoSanitario->vacunado_fiebre_aftosa || $ganado->datoSanitario->vacunado_antirabica): ?>
                                    <div class="col-12 mb-1">
                                        <small class="text-muted d-block mb-1">Vacunaciones Específicas</small>
                                        <?php if($ganado->datoSanitario->vacunado_fiebre_aftosa): ?>
                                            <span class="badge badge-success badge-sm mr-1 mb-1">
                                                <i class="fas fa-check-circle"></i> Vacunado de Libre de Fiebre Aftosa
                                            </span>
                                        <?php endif; ?>
                                        <?php if($ganado->datoSanitario->vacunado_antirabica): ?>
                                            <span class="badge badge-success badge-sm mr-1 mb-1">
                                                <i class="fas fa-check-circle"></i> Vacunado de Antirrábica
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->vacuna): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Otras Vacunas</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->vacuna); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->tratamiento): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Tratamiento</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->tratamiento); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->medicamento): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Medicamento</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->medicamento); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->fecha_aplicacion): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Fecha de Aplicación</small>
                                        <strong class="small"><?php echo e(\Carbon\Carbon::parse($ganado->datoSanitario->fecha_aplicacion)->format('d/m/Y')); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->proxima_fecha): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Próxima Fecha</small>
                                        <strong class="small"><?php echo e(\Carbon\Carbon::parse($ganado->datoSanitario->proxima_fecha)->format('d/m/Y')); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->veterinario): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Veterinario</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->veterinario); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->observaciones): ?>
                                    <div class="col-12 mb-1">
                                        <small class="text-muted d-block">Observaciones</small>
                                        <p class="mb-0 small"><?php echo e($ganado->datoSanitario->observaciones); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->certificado_imagen): ?>
                                    <div class="col-12 mb-1">
                                        <small class="text-muted d-block mb-1">Certificado de Vacunación SENASAG</small>
                                        <div class="btn-inline-img">
                                            <a href="<?php echo e(asset('storage/'.$ganado->datoSanitario->certificado_imagen)); ?>" 
                                               target="_blank" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-file-image"></i> Ver Certificado
                                            </a>
                                            <img src="<?php echo e(asset('storage/'.$ganado->datoSanitario->certificado_imagen)); ?>" 
                                                 alt="Certificado SENASAG" 
                                                 class="img-thumbnail img-preview-inline" 
                                                 style="max-width: 120px; max-height: 80px; cursor: pointer; object-fit: cover;"
                                                 onclick="window.open('<?php echo e(asset('storage/'.$ganado->datoSanitario->certificado_imagen)); ?>', '_blank')"
                                                 title="Click para ver imagen completa">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if($ganado->datoSanitario->marca_ganado || $ganado->datoSanitario->senal_numero || $ganado->datoSanitario->marca_ganado_foto): ?>
                        <div class="section-divider">
                            <h6 class="text-muted mb-1 small font-weight-bold">
                                <i class="fas fa-tag text-primary"></i> Marca del Animal
                            </h6>
                            <div class="row">
                                <?php if($ganado->datoSanitario->marca_ganado): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Marca del Ganado</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->marca_ganado); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->senal_numero): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Señal o #</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->senal_numero); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->marca_ganado_foto): ?>
                                    <div class="col-12 mb-1">
                                        <small class="text-muted d-block mb-1">Foto de la Marca</small>
                                        <div class="btn-inline-img">
                                            <a href="<?php echo e(asset('storage/'.$ganado->datoSanitario->marca_ganado_foto)); ?>" 
                                               target="_blank" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-image"></i> Ver Foto Marca
                                            </a>
                                            <img src="<?php echo e(asset('storage/'.$ganado->datoSanitario->marca_ganado_foto)); ?>" 
                                                 alt="Foto de la Marca" 
                                                 class="img-thumbnail img-preview-inline" 
                                                 style="max-width: 120px; max-height: 80px; cursor: pointer; object-fit: cover;"
                                                 onclick="window.open('<?php echo e(asset('storage/'.$ganado->datoSanitario->marca_ganado_foto)); ?>', '_blank')"
                                                 title="Click para ver imagen completa">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($ganado->datoSanitario->nombre_dueño || $ganado->datoSanitario->carnet_dueño_foto): ?>
                        <div class="section-divider">
                            <h6 class="text-muted mb-1 small font-weight-bold">
                                <i class="fas fa-user text-info"></i> Información del Dueño
                            </h6>
                            <div class="row">
                                <?php if($ganado->datoSanitario->nombre_dueño): ?>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted d-block">Nombre del Dueño</small>
                                        <strong class="small"><?php echo e($ganado->datoSanitario->nombre_dueño); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->carnet_dueño_foto): ?>
                                    <div class="col-12 mb-1">
                                        <small class="text-muted d-block mb-1">Carnet del Dueño</small>
                                        <div class="btn-inline-img">
                                            <a href="<?php echo e(asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto)); ?>" 
                                               target="_blank" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-id-card"></i> Ver Carnet
                                            </a>
                                            <img src="<?php echo e(asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto)); ?>" 
                                                 alt="Carnet Dueño" 
                                                 class="img-thumbnail img-preview-inline" 
                                                 style="max-width: 120px; max-height: 80px; cursor: pointer; object-fit: cover;"
                                                 onclick="window.open('<?php echo e(asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto)); ?>', '_blank')"
                                                 title="Click para ver imagen completa">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Ubicación y Fechas -->
            <div class="card shadow-sm border-0 mb-2">
                <div class="card-header bg-white border-bottom py-1 px-2">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-map-marker-alt text-danger"></i> Ubicación
                    </h5>
                </div>
                <div class="card-body p-2">
                    <?php if($ganado->ciudad || $ganado->municipio || $ganado->departamento): ?>
                        <div class="mb-2">
                            <div class="row mb-1">
                                <div class="col-4">
                                    <strong class="small">Ciudad:</strong>
                                </div>
                                <div class="col-8">
                                    <span class="small"><?php echo e($ganado->ciudad ?? $ganado->municipio ?? 'No disponible'); ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <strong class="small">Dirección:</strong>
                                </div>
                                <div class="col-8">
                                    <?php
                                        $direccion = [];
                                        if($ganado->municipio) $direccion[] = $ganado->municipio;
                                        if($ganado->provincia) $direccion[] = 'Provincia ' . $ganado->provincia;
                                        if($ganado->departamento) $direccion[] = $ganado->departamento;
                                        $direccion[] = 'Bolivia';
                                        $direccionCompleta = implode(', ', $direccion);
                                    ?>
                                    <span class="small"><?php echo e($direccionCompleta); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php elseif($ganado->ubicacion): ?>
                        <p class="mb-2 small">
                            <i class="fas fa-location-dot text-danger"></i> 
                            <strong><?php echo e($ganado->ubicacion); ?></strong>
                        </p>
                    <?php else: ?>
                        <p class="text-muted mb-2 small">Sin ubicación especificada</p>
                    <?php endif; ?>
                    <?php if($ganado->latitud && $ganado->longitud): ?>
                        <button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#mapModal">
                            <i class="fas fa-map"></i> Ver Mapa
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card shadow-sm border-0 mb-2">
                <div class="card-header bg-white border-bottom py-1 px-2">
                    <h5 class="mb-0 h6">
                        <i class="fas fa-calendar-alt text-info"></i> Fechas
                    </h5>
                </div>
                <div class="card-body p-2">
                    <?php if($ganado->fecha_publicacion): ?>
                        <div>
                            <small class="text-muted d-block mb-0">Fecha de Publicación</small>
                            <strong class="small"><?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?></strong>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0 small">Sin fecha de publicación</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información del Vendedor -->
            <?php if($ganado->user): ?>
            <div class="card shadow-sm border-0 border-success border-3">
                <div class="card-header bg-success text-white py-2 px-2">
                    <h5 class="mb-0 h6 font-weight-bold">
                        <i class="fas fa-user"></i> Información del Vendedor
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 font-weight-bold text-dark"><?php echo e($ganado->user->name); ?></h6>
                            <small class="text-muted d-block">
                                <i class="fas fa-envelope text-success"></i> <?php echo e($ganado->user->email); ?>

                            </small>
                        </div>
                    </div>
                    
                    <div class="border-top pt-2">
                        <?php if($ganado->user->role): ?>
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Tipo de Usuario</small>
                                <?php
                                    $roleName = $ganado->user->role->nombre ?? $ganado->user->role_name ?? 'Cliente';
                                    $badgeClass = 'badge-secondary';
                                    if($roleName === 'Administrador' || $roleName === 'admin') {
                                        $badgeClass = 'badge-danger';
                                    } elseif($roleName === 'Vendedor' || $roleName === 'vendedor') {
                                        $badgeClass = 'badge-success';
                                    }
                                ?>
                                <span class="badge <?php echo e($badgeClass); ?> badge-lg px-3 py-1">
                                    <i class="fas fa-user-tag"></i> <?php echo e($roleName); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($ganado->user->created_at): ?>
                            <div class="mb-0">
                                <small class="text-muted d-block mb-1">Miembro desde</small>
                                <strong class="small">
                                    <i class="fas fa-calendar-check text-success"></i> 
                                    <?php echo e(\Carbon\Carbon::parse($ganado->user->created_at)->format('d/m/Y')); ?>

                                </strong>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->id() !== $ganado->user_id): ?>
                            <div class="mt-3 pt-2 border-top">
                                <a href="mailto:<?php echo e($ganado->user->email); ?>" class="btn btn-success btn-sm btn-block shadow-sm">
                                    <i class="fas fa-envelope mr-1"></i> Contactar Vendedor
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="mt-3 pt-2 border-top">
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-success btn-sm btn-block">
                                <i class="fas fa-sign-in-alt mr-1"></i> Inicia sesión para contactar
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
<?php if($ganado->latitud && $ganado->longitud): ?>
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación del Anuncio
                </h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div id="map-ganado-modal" style="height:500px; width:100%;"></div>
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
// Esperar a que todo esté cargado
window.addEventListener('load', function() {
    $(document).ready(function() {
        let mapGanado = null;
        
        <?php
            $popupText = $ganado->nombre;
            if($ganado->ciudad || $ganado->municipio) {
                $popupText .= ' - ' . ($ganado->ciudad ?? $ganado->municipio);
            }
            if($ganado->municipio || $ganado->provincia || $ganado->departamento) {
                $direccion = [];
                if($ganado->municipio) $direccion[] = $ganado->municipio;
                if($ganado->provincia) $direccion[] = 'Provincia ' . $ganado->provincia;
                if($ganado->departamento) $direccion[] = $ganado->departamento;
                $direccion[] = 'Bolivia';
                $popupText .= ' - ' . implode(', ', $direccion);
            } elseif($ganado->ubicacion) {
                $popupText .= ' - ' . $ganado->ubicacion;
            }
        ?>

        function initMap() {
            if (typeof L === 'undefined') {
                console.error('Leaflet no está disponible');
                return false;
            }
            
            try {
                mapGanado = L.map('map-ganado-modal').setView(
                    [<?php echo e($ganado->latitud); ?>, <?php echo e($ganado->longitud); ?>],
                    12
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapGanado);

                L.marker([<?php echo e($ganado->latitud); ?>, <?php echo e($ganado->longitud); ?>])
                    .addTo(mapGanado)
                    .bindPopup("<?php echo e(addslashes($popupText)); ?>");
                
                return true;
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
                return false;
            }
        }

        $('#mapModal').on('shown.bs.modal', function () {
            if (!mapGanado) {
                // Esperar a que el modal esté completamente visible
                setTimeout(function() {
                    if (!initMap()) {
                        // Si falla, reintentar después de un momento
                        setTimeout(initMap, 500);
                    }
                }, 200);
            } else {
                // Si el mapa ya existe, solo invalidar el tamaño
                setTimeout(function() {
                    mapGanado.invalidateSize();
                }, 100);
            }
        });
    });
});
</script>
<?php endif; ?>


<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <button type="button" class="close text-white ml-auto mr-2 mt-2" data-dismiss="modal" aria-label="Close" style="font-size: 2rem; z-index: 1051;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0 text-center">
                <img id="imageModalImg" src="" class="img-fluid rounded"
                     style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/ganados/show.blade.php ENDPATH**/ ?>