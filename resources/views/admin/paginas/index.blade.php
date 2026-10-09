<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Páginas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($paginas as $pagina)
                        <li class="py-3 flex items-center justify-between">
                            <div>
                                <a href="{{ route('admin.paginas.show', $pagina) }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $pagina->titulo }}
                                </a>
                                <span class="text-sm text-gray-500 dark:text-gray-400">/{{ $pagina->slug }}</span>
                            </div>
                            <form method="POST" action="{{ route('admin.paginas.destroy', $pagina) }}" onsubmit="return confirm('¿Eliminar esta página y todo su contenido?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Eliminar') }}</x-danger-button>
                            </form>
                        </li>
                    @empty
                        <li class="py-3 text-gray-500 dark:text-gray-400">{{ __('Todavía no hay páginas.') }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-4">{{ __('Nueva página') }}</h3>
                <form method="POST" action="{{ route('admin.paginas.store') }}" class="flex flex-col sm:flex-row gap-4 sm:items-end">
                    @csrf
                    <div class="flex-1">
                        <x-input-label for="titulo" :value="__('Título')" />
                        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="slug" :value="__('Slug')" />
                        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" placeholder="home" required />
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>
                    <x-primary-button type="submit">{{ __('Crear') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
