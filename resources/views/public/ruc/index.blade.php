<x-layouts.public :titulo="'Consulta de RUC'">
    <div class="bg-white shadow-sm rounded-lg p-6 sm:p-8">
        <h1 class="text-2xl font-semibold text-gray-900">Consulta de RUC</h1>
        <p class="mt-2 text-gray-600">Buscá por número de RUC o por nombre/razón social.</p>

        <form id="ruc-form" method="POST" action="{{ route('publico.ruc.buscar') }}" class="mt-6">
            @csrf
            <input type="hidden" name="recaptcha_token" id="recaptcha_token">

            <div class="relative flex items-center bg-gray-50 border border-gray-300 rounded-full shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 overflow-hidden">
                <svg class="w-5 h-5 ml-4 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3-3"/></svg>
                <input id="consulta" name="consulta" type="text" value="{{ old('consulta', $buscado ?? '') }}"
                       placeholder="Buscar por RUC o por nombre/razón social..."
                       class="flex-1 border-0 bg-transparent focus:ring-0 text-sm py-3 px-3">
                <button type="submit" class="m-1 px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-full hover:bg-indigo-700 transition">
                    Buscar
                </button>
            </div>
            @error('consulta')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('recaptcha_token')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @unless (config('services.recaptcha.site_key'))
                <p class="mt-1.5 text-xs text-amber-600">reCAPTCHA sin configurar todavía (modo desarrollo).</p>
            @endunless
        </form>

        @if (session()->exists('resultados'))
            @php $resultados = session('resultados', []); @endphp
            <div class="mt-8 border-t border-gray-200 pt-6">
                @if (count($resultados) === 1)
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                        <div>
                            <dt class="text-gray-500">RUC</dt>
                            <dd class="font-medium text-gray-900">{{ $resultados[0]['ruc_completo'] }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500">Nombre / Razón social</dt>
                            <dd class="font-medium text-gray-900">{{ \App\Services\RucBuscador::nombreLegible($resultados[0]['razon_social']) }}</dd>
                        </div>
                    </dl>
                @elseif (count($resultados) > 1)
                    <p class="text-sm text-gray-500 mb-4">{{ count($resultados) }} coincidencias para <strong>{{ session('buscado') }}</strong>:</p>
                    <ul class="divide-y divide-gray-100 border border-gray-100 rounded-lg overflow-hidden">
                        @foreach ($resultados as $fila)
                            <li class="px-4 py-3 text-sm">
                                <div class="font-medium text-gray-900">{{ \App\Services\RucBuscador::nombreLegible($fila['razon_social']) }}</div>
                                <div class="text-gray-500">RUC {{ $fila['ruc_completo'] }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-600">No se encontraron resultados para <strong>{{ session('buscado') }}</strong>.</p>
                @endif
            </div>
        @endif
    </div>

    @if (config('services.recaptcha.site_key'))
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
            <script>
                document.getElementById('ruc-form').addEventListener('submit', function (e) {
                    e.preventDefault();
                    const form = this;
                    grecaptcha.ready(function () {
                        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'consulta_ruc' }).then(function (token) {
                            document.getElementById('recaptcha_token').value = token;
                            form.submit();
                        });
                    });
                });
            </script>
        @endpush
    @endif
</x-layouts.public>
