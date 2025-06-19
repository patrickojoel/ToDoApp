<?php
session_start(); // Inicia la sesión para poder destruirla

// Ruta del archivo de log
$logDir = __DIR__ . '/logs';
$logFile = $logDir . '/debug.log';

// Asegurarse que el directorio de logs existe
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

// Función para escribir en log
function log_msg($msg) {
    global $logFile;
    if (is_writable(dirname($logFile))) {
        @file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] $msg\n", FILE_APPEND);
    }
}

log_msg("👋 Logout iniciado por el usuario: " . ($_SESSION['usuario'] ?? 'desconocido'));

// Elimina todos los datos de sesión
session_unset();      // Elimina todas las variables de sesión
session_destroy();    // Destruye la sesión actual

log_msg("✅ Sesión cerrada correctamente");

// Redirige al login
header("Location: ../frontend/index.html");
exit;
?>
