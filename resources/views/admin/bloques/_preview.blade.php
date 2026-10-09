@php
    $resumen = match ($bloque->tipo) {
        'texto' => $bloque->contenido['titulo'] ?? \Illuminate\Support\Str::limit($bloque->contenido['cuerpo'] ?? '', 60),
        'imagen' => $bloque->contenido['alt'] ?? '',
        'tarjeta' => $bloque->contenido['titulo'] ?? '',
        'boton' => $bloque->contenido['texto'] ?? '',
        default => '',
    };
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
    {{ \App\Models\Bloque::TIPOS[$bloque->tipo] ?? $bloque->tipo }}
</span>
<span class="text-gray-700 dark:text-gray-300">{{ $resumen }}</span>
