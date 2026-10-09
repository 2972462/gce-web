<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo bloque en :seccion', ['seccion' => $seccion->titulo]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @if (! $tipo)
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('Elegí el tipo de bloque:') }}</p>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach (\App\Models\Bloque::TIPOS as $valor => $etiqueta)
                            <a href="{{ route('admin.bloques.create', ['seccion' => $seccion, 'tipo' => $valor]) }}"
                               class="block text-center px-4 py-3 border rounded-md border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200">
                                {{ $etiqueta }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.bloques.store', $seccion) }}">
                        @csrf
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        @include('admin.bloques._campos', ['tipo' => $tipo, 'contenido' => []])

                        <div class="mt-6 flex items-center gap-3">
                            <x-primary-button type="submit">{{ __('Crear bloque') }}</x-primary-button>
                            <a href="{{ route('admin.paginas.show', $seccion->pagina_id) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
