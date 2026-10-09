<x-layouts.public :titulo="'Consulta de RUC'">
    <div class="bg-white shadow-sm rounded-lg p-6 sm:p-8">
        <h1 class="text-2xl font-semibold text-gray-900">Consulta de RUC</h1>
        <p class="mt-2 text-gray-600">Ingresa un número de RUC para verificar la razón social asociada.</p>

        <form method="POST" action="{{ route('publico.ruc.buscar') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="ruc" class="block text-sm font-medium text-gray-700">Número de RUC</label>
                <input id="ruc" name="ruc" type="text" inputmode="numeric" value="{{ old('ruc', $buscado ?? '') }}"
                       placeholder="80012345"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('ruc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                @if (config('services.recaptcha.site_key'))
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                @else
                    <p class="text-xs text-amber-600">reCAPTCHA sin configurar todavía (modo desarrollo).</p>
                @endif
                @error('g-recaptcha-response')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Consultar
            </button>
        </form>

        @if (session()->exists('resultado'))
            <div class="mt-8 border-t border-gray-200 pt-6">
                @if ($resultado = session('resultado'))
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                        <div>
                            <dt class="text-gray-500">RUC</dt>
                            <dd class="font-medium text-gray-900">{{ $resultado['ruc_completo'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Estado</dt>
                            <dd class="font-medium text-gray-900">{{ $resultado['estado'] ?? '—' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500">Razón social</dt>
                            <dd class="font-medium text-gray-900">{{ $resultado['razon_social'] }}</dd>
                        </div>
                    </dl>
                @else
                    <p class="text-sm text-gray-600">No se encontró ningún RUC con el número <strong>{{ session('buscado') }}</strong>.</p>
                @endif
            </div>
        @endif
    </div>

    @if (config('services.recaptcha.site_key'))
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endif
</x-layouts.public>
