<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $pagina->titulo }}
            </h2>
            <a href="{{ route('admin.paginas.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:underline">
                {{ __('← Todas las páginas') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @foreach ($pagina->secciones as $seccion)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h3 class="font-medium text-gray-800 dark:text-gray-200">{{ $seccion->titulo }}</h3>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $seccion->clave }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.secciones.mover-arriba', $seccion) }}">
                                @csrf
                                <x-secondary-button type="submit" title="{{ __('Subir') }}">&uarr;</x-secondary-button>
                            </form>
                            <form method="POST" action="{{ route('admin.secciones.mover-abajo', $seccion) }}">
                                @csrf
                                <x-secondary-button type="submit" title="{{ __('Bajar') }}">&darr;</x-secondary-button>
                            </form>
                            <details class="relative">
                                <summary class="list-none cursor-pointer">
                                    <x-secondary-button type="button">{{ __('Editar') }}</x-secondary-button>
                                </summary>
                                <form method="POST" action="{{ route('admin.secciones.update', $seccion) }}"
                                      class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg p-4 z-10 space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <x-input-label for="clave-{{ $seccion->id }}" :value="__('Clave')" />
                                        <x-text-input id="clave-{{ $seccion->id }}" name="clave" type="text" class="mt-1 block w-full" value="{{ $seccion->clave }}" required />
                                    </div>
                                    <div>
                                        <x-input-label for="titulo-{{ $seccion->id }}" :value="__('Título')" />
                                        <x-text-input id="titulo-{{ $seccion->id }}" name="titulo" type="text" class="mt-1 block w-full" value="{{ $seccion->titulo }}" required />
                                    </div>
                                    <x-primary-button type="submit">{{ __('Guardar') }}</x-primary-button>
                                </form>
                            </details>
                            <form method="POST" action="{{ route('admin.secciones.destroy', $seccion) }}" onsubmit="return confirm('¿Eliminar esta sección y sus bloques?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Eliminar') }}</x-danger-button>
                            </form>
                        </div>
                    </div>

                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($seccion->bloques as $bloque)
                            <li class="flex items-center justify-between px-6 py-3 gap-4">
                                <div class="flex items-center gap-2 min-w-0">
                                    @include('admin.bloques._preview', ['bloque' => $bloque])
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <form method="POST" action="{{ route('admin.bloques.mover-arriba', $bloque) }}">
                                        @csrf
                                        <x-secondary-button type="submit" title="{{ __('Subir') }}">&uarr;</x-secondary-button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.bloques.mover-abajo', $bloque) }}">
                                        @csrf
                                        <x-secondary-button type="submit" title="{{ __('Bajar') }}">&darr;</x-secondary-button>
                                    </form>
                                    <a href="{{ route('admin.bloques.edit', $bloque) }}"
                                       class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                                        {{ __('Editar') }}
                                    </a>
                                    <form method="POST" action="{{ route('admin.bloques.destroy', $bloque) }}" onsubmit="return confirm('¿Eliminar este bloque?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit">{{ __('Eliminar') }}</x-danger-button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-3 text-sm text-gray-500 dark:text-gray-400">{{ __('Esta sección todavía no tiene bloques.') }}</li>
                        @endforelse
                    </ul>

                    <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.bloques.create', $seccion) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ __('+ Agregar bloque') }}
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-4">{{ __('Nueva sección') }}</h3>
                <form method="POST" action="{{ route('admin.secciones.store', $pagina) }}" class="flex flex-col sm:flex-row gap-4 sm:items-end">
                    @csrf
                    <div class="flex-1">
                        <x-input-label for="clave" :value="__('Clave')" />
                        <x-text-input id="clave" name="clave" type="text" class="mt-1 block w-full" placeholder="hero" required />
                        <x-input-error :messages="$errors->get('clave')" class="mt-2" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="seccion_titulo" :value="__('Título')" />
                        <x-text-input id="seccion_titulo" name="titulo" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                    </div>
                    <x-primary-button type="submit">{{ __('Agregar') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
