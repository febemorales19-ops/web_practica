<?php
require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM solicitudes ORDER BY creado_en DESC");
$solicitudes = $stmt->fetchAll();

echo json_encode(['ok' => true, 'data' => $solicitudes]);
