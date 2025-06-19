<?php
// Función que carga datos de un archivo JSON y los convierte en array PHP
function loadData($filename) {
    if (!file_exists($filename)) return [];
    $data = file_get_contents($filename);
    return json_decode($data, true);
}

// Función que guarda datos en un archivo JSON
function saveData($filename, $data) {
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}
?>