<x-layouts.public :titulo="'Consulta de RUC'">
    <div class="bg-white shadow-sm rounded-lg p-6 sm:p-8"
         x-data="consultaRuc({{ Illuminate\Support\Js::from(session()->exists('resultados') ? session('resultados') : null) }}, {{ Illuminate\Support\Js::from(session('buscado', '')) }})">
        <h1 class="text-2xl font-semibold text-gray-900">Consulta de RUC</h1>
        <p class="mt-2 text-gray-600">Buscá por número de RUC o por nombre/razón social.</p>

        <form id="ruc-form" method="POST" action="{{ route('publico.ruc.buscar') }}" class="mt-6">
            @csrf
            <input type="hidden" name="recaptcha_token" id="recaptcha_token">

            <div class="relative flex items-center bg-gray-50 border border-gray-300 rounded-full shadow-sm focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 overflow-hidden">
                <svg class="w-5 h-5 ml-4 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3-3"/></svg>
                <input id="consulta" name="consulta" type="text" value="{{ old('consulta', $buscado ?? '') }}"
                       placeholder="Buscar por RUC o por nombre/razón social..."
                       @input.debounce.400ms="buscarEnVivo($event.target.value)"
                       autocomplete="off"
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
            <p class="mt-1.5 text-sm text-red-600" x-show="errorVivo">No se pudo buscar en vivo. Probá de nuevo o apretá "Buscar".</p>
        </form>

        <template x-if="resultados !== null">
            <div class="mt-8 border-t border-gray-200 pt-6">
                <template x-if="resultados.length === 1">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                        <div>
                            <dt class="text-gray-500">RUC</dt>
                            <dd class="font-medium text-gray-900" x-text="resultados[0].ruc_completo"></dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500">Nombre / Razón social</dt>
                            <dd class="font-medium text-gray-900" x-text="nombreLegible(resultados[0].razon_social)"></dd>
                        </div>
                    </dl>
                </template>
                <template x-if="resultados.length > 1">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">
                            <span x-text="resultados.length"></span> coincidencias para <strong x-text="buscado"></strong>:
                        </p>
                        <p class="text-xs text-gray-400 mb-4" x-show="resultados.length === {{ \App\Services\RucBuscador::MAX_RESULTADOS_NOMBRE }}">
                            Mostrando las primeras {{ \App\Services\RucBuscador::MAX_RESULTADOS_NOMBRE }}. Agregá más datos (apellido, segundo nombre) para afinar la búsqueda.
                        </p>
                        <ul class="divide-y divide-gray-100 border border-gray-100 rounded-lg overflow-hidden">
                            <template x-for="fila in resultados" :key="fila.ruc_completo">
                                <li class="px-4 py-3 text-sm">
                                    <div class="font-medium text-gray-900" x-text="nombreLegible(fila.razon_social)"></div>
                                    <div class="text-gray-500">RUC <span x-text="fila.ruc_completo"></span></div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>
                <template x-if="resultados.length === 0">
                    <p class="text-sm text-gray-600">No se encontraron resultados para <strong x-text="buscado"></strong>.</p>
                </template>
            </div>
        </template>
    </div>

    @if (config('services.recaptcha.site_key'))
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        @endpush
    @endif

    @push('scripts')
        <script>
            function consultaRuc(resultadosIniciales, buscadoInicial) {
                return {
                    resultados: resultadosIniciales,
                    buscado: buscadoInicial || '',
                    recaptchaSiteKey: {{ Illuminate\Support\Js::from(config('services.recaptcha.site_key')) }},

                    // La búsqueda "oficial" (la que queda en ConsultaRuc, con
                    // IP/puntaje/etc.) sigue siendo solo la del botón
                    // "Buscar"/Enter -ver RucController::buscar()-; esta vista
                    // previa en vivo usa un endpoint aparte que no guarda nada.
                    errorVivo: false,

                    async buscarEnVivo(valor) {
                        const texto = valor.trim();
                        if (texto.length < 3) {
                            this.resultados = texto === '' ? null : this.resultados;
                            this.errorVivo = false;

                            return;
                        }

                        this.errorVivo = false;

                        try {
                            const token = await this.obtenerRecaptchaToken();
                            const url = `{{ route('publico.ruc.buscar-vivo') }}?${new URLSearchParams({ consulta: texto, recaptcha_token: token })}`;
                            const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
                            if (!response.ok) {
                                this.errorVivo = true;

                                return;
                            }
                            const data = await response.json();
                            this.resultados = data.resultados;
                            this.buscado = data.buscado;
                        } catch (e) {
                            // Sin conexión, reCAPTCHA que no cargó, etc.: se
                            // avisa en vez de quedar en silencio -"Buscar"
                            // (recarga completa de página) sigue andando
                            // siempre como alternativa-.
                            this.errorVivo = true;
                        }
                    },

                    // Nunca deja esperando para siempre: si grecaptcha.ready()
                    // no llega a ejecutar el callback (script bloqueado,
                    // adblock, etc.) o .execute() rechaza la promesa, se
                    // resuelve igual a los 4s para no trabar la búsqueda.
                    obtenerRecaptchaToken() {
                        if (!this.recaptchaSiteKey || typeof grecaptcha === 'undefined') {
                            return Promise.resolve('');
                        }

                        const token = new Promise((resolve) => {
                            grecaptcha.ready(() => {
                                grecaptcha.execute(this.recaptchaSiteKey, { action: 'consulta_ruc' })
                                    .then(resolve)
                                    .catch(() => resolve(''));
                            });
                        });
                        const limite = new Promise((resolve) => setTimeout(() => resolve(''), 4000));

                        return Promise.race([token, limite]);
                    },

                    // Mismo criterio que RucBuscador::nombreLegible(): las
                    // personas físicas vienen "APELLIDO/S, NOMBRE/S", se
                    // invierte solo cuando hay coma.
                    nombreLegible(razonSocial) {
                        const idx = razonSocial.indexOf(',');
                        if (idx === -1) return razonSocial;

                        const apellido = razonSocial.slice(0, idx).trim();
                        const nombre = razonSocial.slice(idx + 1).trim();

                        return `${nombre} ${apellido}`.trim();
                    },
                };
            }

            document.getElementById('ruc-form').addEventListener('submit', function (e) {
                const siteKey = {{ Illuminate\Support\Js::from(config('services.recaptcha.site_key')) }};
                if (!siteKey || typeof grecaptcha === 'undefined') return;

                e.preventDefault();
                const form = this;
                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: 'consulta_ruc' }).then(function (token) {
                        document.getElementById('recaptcha_token').value = token;
                        form.submit();
                    });
                });
            });
        </script>
    @endpush
</x-layouts.public>
