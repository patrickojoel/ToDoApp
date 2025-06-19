<?php
session_start(); // Inicia o recupera la sesión del usuario actual
header('Content-Type: application/json'); // Devuelve la respuesta como JSON

// Rutas y log
$logDir = __DIR__ . '/logs';
$logFile = $logDir . '/debug.log';

// Crear carpeta logs si no existe
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

// Función de logging seguro
function log_msg($msg) {
    global $logFile;
    @file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] $msg\n", FILE_APPEND);
}

try {
    log_msg("🔐 [LOGIN] Acceso a login.php");

    // Obtener datos enviados por el frontend (JSON POST)
    $input = file_get_contents("php://input");
    if (!$input) throw new Exception("⚠️ No se recibió ningún dato del cliente.");

    log_msg("📨 JSON recibido: " . $input);
    $data = json_decode($input, true);

    // Validar presencia de datos necesarios
    if (!isset($data['usuario']) || !isset($data['password'])) {
        throw new Exception("❌ Faltan usuario o contraseña.");
    }

    $usuarioIngresado = trim($data['usuario']);
    $passwordIngresado = trim($data['password']);

    log_msg("👤 Usuario: $usuarioIngresado");

    // Leer usuarios del archivo JSON
    $usuariosFile = __DIR__ . '/usuarios.json';
    if (!file_exists($usuariosFile)) throw new Exception("📂 Archivo usuarios.json no encontrado.");

    $usuarios = json_decode(file_get_contents($usuariosFile), true);
    if (!$usuarios) throw new Exception("📄 Error al leer usuarios.json");

    // Buscar usuario válido
    foreach ($usuarios as $usuario) {
        if (
            $usuario['usuario'] === $usuarioIngresado &&
            $usuario['password'] === $passwordIngresado
        ) {
            // Guardar objeto completo en sesión
            $_SESSION['usuario'] = [
                'usuario' => $usuario['usuario'],
                'nombre' => $usuario['nombre']
            ];

            log_msg("✅ Login correcto: " . $usuario['nombre']);

            echo json_encode([
                'success' => true,
                'usuario' => $usuario['nombre']
            ]);
            exit;
        }
    }

    log_msg("❌ Login fallido: credenciales inválidas");

    echo json_encode([
        'success' => false,
        'error' => 'Usuario o contraseña incorrectos.'
    ]);
} catch (Exception $e) {
    log_msg("💥 Excepción: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
