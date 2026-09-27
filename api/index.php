<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADQUISICION</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/estilo.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <aside class="col-12 col-md-3 col-lg-2 sidebar">
            <div class="brand mb-4">
                <h5><title>ADQUISICION</title></h5>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" href="#" id="tab-nueva">🛒 Nueva Solicitud</a>
                <a class="nav-link" href="#" id="tab-historial">🕘 Historial</a>
            </nav>
        </aside>

        <!-- Contenido -->
        <main class="col-12 col-md-9 col-lg-10 p-0">

            <div class="topbar d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" id="titulo-seccion">Nueva Solicitud de Compra</h6>
            </div>

            <div class="p-4" id="vista-nueva">

                <div id="alerta-form" class="alert d-none" role="alert"></div>

                <form id="formSolicitud" style="max-width: 900px;">

                    <!-- Información del proveedor -->
                    <div class="seccion-card">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icono-box">🏢</div>
                            <div>
                                <h6>Información del Proveedor</h6>
                                <div class="subt">Seleccione la entidad comercial para esta orden</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Proveedor</label>
                                <input type="text" class="form-control" name="proveedor" placeholder="Nombre del proveedor" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Punto de contacto</label>
                                <input type="text" class="form-control" name="contacto" placeholder="Nombre del representante">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="correo" placeholder="contacto@proveedor.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono corporativo</label>
                                <input type="text" class="form-control" name="telefono" placeholder="+52 (55) 1234-5678">
                            </div>
                        </div>
                    </div>

                    <!-- Detalle del producto -->
                    <div class="seccion-card">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icono-box">📋</div>
                            <div>
                                <h6>Detalle del Producto</h6>
                                <div class="subt">Información técnica y financiera del item</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del producto</label>
                                <input type="text" class="form-control" name="producto" id="producto" placeholder="Ej: Plástico" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">SKU / Código</label>
                                <input type="text" class="form-control" name="sku" placeholder="STR-09923-X">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" class="form-control" name="cantidad" id="cantidad" min="1" value="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Precio unitario</label>
                                <input type="number" step="0.01" class="form-control" name="precio_unitario" id="precio_unitario" placeholder="$ 0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subtotal estimado</label>
                                <input type="text" class="form-control" id="subtotal-estimado" readonly value="$ 0.00">
                            </div>
                        </div>
                    </div>

                    <!-- Logística de entrega -->
                    <div class="seccion-card">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icono-box">🚚</div>
                            <div>
                                <h6>Logística de Entrega</h6>
                                <div class="subt">Defina cuándo y dónde se requiere el pedido</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de entrega solicitada</label>
                                <input type="date" class="form-control" name="fecha_entrega">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prioridad de envío</label>
                                <select class="form-select" name="prioridad">
                                    <option value="Estándar (5-7 días)" selected>Estándar (5-7 días)</option>
                                    <option value="Urgente (2-3 días)">Urgente (2-3 días)</option>
                                    <option value="Mismo día">Mismo día</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dirección de entrega</label>
                                <input type="text" class="form-control" name="direccion" placeholder="Calle, número, colonia, ciudad">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <button type="submit" class="btn btn-registrar text-white">Registrar Solicitud</button>
                    </div>

                </form>
            </div>

            <!-- Vista de Historial (oculta al inicio) -->
            <div class="p-4 d-none" id="vista-historial">

                <div id="alerta-historial" class="alert d-none" role="alert"></div>

                <div class="seccion-card">
                    <div class="table-responsive">
                        <table class="table tabla-historial">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Proveedor</th>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Subtotal</th>
                                    <th>Entrega</th>
                                    <th>Prioridad</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cuerpo-tabla"></tbody>
                        </table>
                        <p id="sin-datos" class="text-muted text-center py-4 d-none">Todavía no hay solicitudes registradas.</p>
                    </div>
                </div>

            </div>

        </main>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
