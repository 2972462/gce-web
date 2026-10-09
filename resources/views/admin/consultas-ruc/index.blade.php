<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Consultas de RUC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/40 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left">Fecha</th>
                            <th class="px-4 py-2 text-left">Búsqueda</th>
                            <th class="px-4 py-2 text-left">Resultado</th>
                            <th class="px-4 py-2 text-left">IP</th>
                            <th class="px-4 py-2 text-left">Dispositivo</th>
                            <th class="px-4 py-2 text-right">Puntaje</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($consultas as $consulta)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $consulta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900 dark:text-gray-100">{{ $consulta->ruc_buscado }}</td>
                                <td class="px-4 py-2">
                                    @if ($consulta->resultados_count === 1)
                                        <span class="text-green-700 dark:text-green-400">{{ $consulta->razon_social }}</span>
                                        <span class="text-gray-400">({{ $consulta->estado ?? '—' }})</span>
                                    @elseif ($consulta->resultados_count > 1)
                                        <span class="text-amber-700 dark:text-amber-400">{{ $consulta->resultados_count }} coincidencias</span>
                                    @else
                                        <span class="text-gray-400">No encontrado</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{ $consulta->ip }}</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $consulta->user_agent }}">{{ $consulta->user_agent }}</td>
                                <td class="px-4 py-2 text-right text-gray-500 dark:text-gray-400">{{ $consulta->recaptcha_score !== null ? number_format($consulta->recaptcha_score, 2) : '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-400">Todavía no hay consultas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $consultas->links() }}
        </div>
    </div>
</x-app-layout>
