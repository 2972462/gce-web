<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuración del sitio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg p-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">Logos del sitio</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    El logo izquierdo se muestra en la cabecera y el pie de página. El logo derecho es
                    opcional (por ejemplo, un sello o certificación) y aparece del lado opuesto de la cabecera.
                </p>

                <form method="POST" action="{{ route('admin.site-settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid sm:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="logo_izquierdo" value="Logo izquierdo" />
                            <div class="mt-2 flex items-center gap-4">
                                <img src="{{ $siteSetting->logoIzquierdoUrl() }}" alt="Logo izquierdo actual" class="h-16 w-auto bg-slate-50 rounded border border-slate-200 p-1">
                                <div class="flex-1">
                                    <input id="logo_izquierdo" name="logo_izquierdo" type="file" accept="image/*"
                                        class="block w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @if ($siteSetting->logo_izquierdo_path)
                                        <label class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                            <input type="checkbox" name="quitar_logo_izquierdo" value="1" class="rounded border-gray-300">
                                            Quitar y volver al logo por defecto
                                        </label>
                                    @endif
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('logo_izquierdo')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="logo_derecho" value="Logo derecho (opcional)" />
                            <div class="mt-2 flex items-center gap-4">
                                @if ($siteSetting->logoDerechoUrl())
                                    <img src="{{ $siteSetting->logoDerechoUrl() }}" alt="Logo derecho actual" class="h-16 w-auto bg-slate-50 rounded border border-slate-200 p-1">
                                @else
                                    <div class="h-16 w-16 rounded border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-400 text-center px-1">
                                        Sin logo
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input id="logo_derecho" name="logo_derecho" type="file" accept="image/*"
                                        class="block w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @if ($siteSetting->logo_derecho_path)
                                        <label class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                            <input type="checkbox" name="quitar_logo_derecho" value="1" class="rounded border-gray-300">
                                            Quitar logo derecho
                                        </label>
                                    @endif
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('logo_derecho')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Guardar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
