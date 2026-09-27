<?php
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

// Solo aceptamos peticiones POST (las que manda el formulario vía jQuery)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Leemos y limpiamos cada campo que llega del formulario
$proveedor       = trim($_POST['proveedor'] ?? '');
$contacto        = trim($_POST['contacto'] ?? '');
$correo          = trim($_POST['correo'] ?? '');
$telefono        = trim($_POST['telefono'] ?? '');
$producto        = trim($_POST['producto'] ?? '');
$sku             = trim($_POST['sku'] ?? '');
$cantidad        = (int) ($_POST['cantidad'] ?? 1);
$precio_unitario = (float) ($_POST['precio_unitario'] ?? 0);
$fecha_entrega   = trim($_POST['fecha_entrega'] ?? '');
$prioridad       = trim($_POST['prioridad'] ?? '');
$direccion       = trim($_POST['direccion'] ?? '');

// Validación mínima del lado del servidor
if ($proveedor === '' || $producto === '' || $cantidad <= 0) {
    http_response_code(422);
    echo json_encode(['error' => 'Proveedor, producto y cantidad son obligatorios.']);
    exit;
}

$subtotal = $cantidad * $precio_unitario;

$sql = "INSERT INTO solicitudes
        (proveedor, contacto, correo, telefono, producto, sku, cantidad, precio_unitario, subtotal, fecha_entrega, prioridad, direccion)
        VALUES
        (:proveedor, :contacto, :correo, :telefono, :producto, :sku, :cantidad, :precio_unitario, :subtotal, :fecha_entrega, :prioridad, :direccion)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':proveedor'       => $proveedor,
    ':contacto'        => $contacto,
    ':correo'          => $correo,
    ':telefono'        => $telefono,
    ':producto'        => $producto,
    ':sku'             => $sku,
    ':cantidad'        => $cantidad,
    ':precio_unitario' => $precio_unitario,
    ':subtotal'        => $subtotal,
    ':fecha_entrega'   => $fecha_entrega ?: null,
    ':prioridad'       => $prioridad,
    ':direccion'       => $direccion,
]);

echo json_encode([
    'ok' => true,
    'id' => $pdo->lastInsertId(),
    'mensaje' => 'Solicitud registrada correctamente.'
]);
