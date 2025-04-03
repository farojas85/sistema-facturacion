<?php

function verificarAccesoActivo(array $roles, array $accesos): bool
{
    // 1. Obtener accesos activos (solo 'activo' = 's')
    $accesosActivos = array_column(
        array_filter($roles, fn($r) => ($r['activo'] ?? 'n') === 's'),
        'nombreacceso'
    );

    // // 2. Comparación insensible a mayúsculas/minúsculas
    // $accesosActivos = array_map('strtoupper', $accesosActivos);
    // $accesosRequeridos = array_map('strtoupper', $accesos);

    // 3. Verificar que NO haya diferencias (todos están presentes)
    return !empty(array_intersect($accesos, $accesosActivos));
}