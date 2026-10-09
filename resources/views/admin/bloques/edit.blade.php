<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar bloque (:tipo)', ['tipo' => \App\Models\Bloque::TIPOS[$bloque->tipo]]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.bloques.update', $bloque) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tipo" value="{{ $bloque->tipo }}">
                    @include('admin.bloques._campos', ['tipo' => $bloque->tipo, 'contenido' => $bloque->contenido])

                    <div class="mt-6 flex items-center gap-3">
                        <x-primary-button type="submit">{{ __('Guardar cambios') }}</x-primary-button>
                        <a href="{{ route('admin.paginas.show', $bloque->seccion->pagina_id) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">{{ __('Cancelar') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
