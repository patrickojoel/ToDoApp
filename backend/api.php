<?php
header('Content-Type: application/json');

// Ruta al archivo de tareas
$tareasFile = 'tareas.json';

// Cargar datos desde JSON
function loadData($file) {
  if (!file_exists($file)) return [];
  return json_decode(file_get_contents($file), true);
}

// Guardar datos en JSON
function saveData($file, $data) {
  file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

$method = $_SERVER['REQUEST_METHOD'];

// === GET: obtener todas las tareas ===
if ($method === 'GET' && isset($_GET['tareas'])) {
  $tareas = loadData($tareasFile);
  echo json_encode($tareas);
  exit;
}

// === POST: crear nueva tarea ===
if ($method === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);
  $tareas = loadData($tareasFile);

  $nuevaTarea = [
    'id' => count($tareas) > 0 ? end($tareas)['id'] + 1 : 1,
    'titulo' => $input['titulo'] ?? '',
    'descripcion' => $input['descripcion'] ?? ''
  ];

  $tareas[] = $nuevaTarea;
  saveData($tareasFile, $tareas);
  echo json_encode($nuevaTarea);
  exit;
}

// === DELETE: eliminar todas las tareas ===
if ($method === 'DELETE' && isset($_GET['todas']) && $_GET['todas'] === 'true') {
  saveData($tareasFile, []);
  echo json_encode(['success' => true, 'mensaje' => 'Todas las tareas han sido eliminadas.']);
  exit;
}

// === DELETE: eliminar por ID ===
if ($method === 'DELETE' && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $tareas = loadData($tareasFile);
  $tareas = array_filter($tareas, fn($t) => $t['id'] !== $id);
  saveData($tareasFile, array_values($tareas));
  echo json_encode(['success' => true]);
  exit;
}

// === PATCH: actualizar por ID ===
if ($method === 'PATCH' && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $input = json_decode(file_get_contents('php://input'), true);
  $tareas = loadData($tareasFile);
  $encontrada = false;

  foreach ($tareas as &$tarea) {
    if ($tarea['id'] === $id) {
      $tarea['titulo'] = $input['titulo'] ?? $tarea['titulo'];
      $tarea['descripcion'] = $input['descripcion'] ?? $tarea['descripcion'];
      $encontrada = true;
      break;
    }
  }

  if ($encontrada) {
    saveData($tareasFile, $tareas);
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Tarea no encontrada']);
  }
  exit;
}

// === Ruta no válida ===
echo json_encode(['error' => 'Ruta o método no válido']);
