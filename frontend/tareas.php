<?php
// Inicia la sesión para acceder a $_SESSION
session_start();

// Ruta para el archivo de logs
$logFile = __DIR__ . '/../backend/logs/debug.log';

// Función para escribir eventos en el log
function log_event($msg) {
  global $logFile;
  file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] tareas.php - $msg\n", FILE_APPEND);
}

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    log_event("⛔ Intento de acceso sin sesión");
    header('Location: index.html');
    exit;
}

// Recupera el nombre del usuario desde la sesión (ya que es un array con 'nombre' y 'usuario')
$usuario = $_SESSION['usuario']['nombre'] ?? 'Usuario desconocido';
log_event("✅ Acceso autorizado como $usuario");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ToDo App</title>

  <!-- Tipografía -->
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

  <!-- Estilos -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

  <!-- Fondo personalizado -->
  <style>
    body {
      background-image: url('img/fondo.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }
  </style>
</head>
<body id="tareas-body">
  <!-- Contenedor principal de tareas -->
  <div id="contenedor-tareas">
    
    <!-- Panel izquierdo con lista de tareas -->
    <div id="tareas-box">
      <h2 id="tareas-title">Todo App</h2>

      <!-- Formulario para agregar nueva tarea -->
      <form id="formNuevaTarea">
        <div id="input-row">
          <input type="text" id="titulo" placeholder="Agregar nueva tarea" required />
          <button type="submit" id="btn-add"><i class="fas fa-plus"></i></button>
        </div>
        <input type="text" id="descripcion" placeholder="Descripción de la tarea" required />
      </form>

      <!-- Lista de tareas -->
      <ul id="listaTareas"></ul>

      <!-- Botón para borrar todas las tareas -->
      <div id="tareas-footer">
        <button id="btn-clear">Borrar Todas</button>
      </div>
    </div>

    <!-- Panel derecho con detalle de tarea -->
    <div id="detalle-box" class="oculto">
      <h3 id="detalle-titulo">Detalle de la tarea</h3>
      <p id="detalle-descripcion"></p>
      <button id="btn-editar" class="btn-editar"><i class="fas fa-pen"></i></button>
    </div>
  </div>

  <!-- Panel de usuario en esquina superior derecha -->
  <div id="usuario-box">
    <img src="img/usuario.jpg" alt="Usuario" id="usuario-foto" />
    <div id="usuario-info">
      <!-- Muestra el nombre completo del usuario desde $_SESSION -->
      <strong id="usuario-nombre"><?= htmlspecialchars($usuario) ?></strong>
      <span>Administrador</span>
    </div>

    <!-- Botón para cerrar sesión -->
    <form action="../backend/logout.php" method="post">
      <button class="btn-logout" type="submit">
        <i class="fas fa-sign-out-alt"></i>
      </button>
    </form>
  </div>

  <!-- Librerías JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="js/tareas.js"></script>
</body>
</html>
