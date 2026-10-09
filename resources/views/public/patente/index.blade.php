<x-layouts.public :titulo="'Cálculo de Patente Comercial'">
    <div x-data="patenteCalculadora({{ Js::from($tramosParaJs) }})" class="space-y-4">
        <div class="bg-white shadow-sm rounded-lg p-6 sm:p-8">
            <h1 class="text-2xl font-semibold text-gray-900">Cálculo de Patente Comercial</h1>
            <p class="mt-2 text-gray-600">Ingresa el monto del activo declarado para calcular el impuesto de Patente Comercial (Ley N° 135/91). El resultado se calcula al instante, sin necesidad de enviar nada.</p>

            <div class="mt-6">
                <label for="monto" class="block text-sm font-medium text-gray-700">Monto del activo declarado (Gs.)</label>
                <div class="relative mt-1">
                    <input id="monto" type="text" inputmode="numeric" :value="montoFormateado" @input="actualizarMonto($event)"
                           placeholder="15.000.000" autofocus
                           class="block w-full text-right tabular-nums pr-9 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="button" x-show="monto !== ''" x-cloak @click="monto = ''" title="Limpiar"
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6 sm:p-8" x-show="resultado" x-cloak>
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <dt class="text-[11px] font-bold uppercase tracking-wide text-gray-400 mb-1">Total anual</dt>
                    <dd class="text-2xl font-extrabold text-gray-800" x-text="'Gs. ' + formatearGs(resultado?.impuesto)"></dd>
                </div>
                <div class="border-t sm:border-t-0 sm:border-l border-gray-100 pt-3 sm:pt-0 sm:pl-4">
                    <dt class="text-[11px] font-bold uppercase tracking-wide text-gray-400 mb-1">1er semestre</dt>
                    <dd class="text-lg font-bold text-gray-700" x-text="'Gs. ' + formatearGs(resultado?.semestre1)"></dd>
                </div>
                <div>
                    <dt class="text-[11px] font-bold uppercase tracking-wide text-gray-400 mb-1">2do semestre</dt>
                    <dd class="text-lg font-bold text-gray-700" x-text="'Gs. ' + formatearGs(resultado?.semestre2)"></dd>
                </div>
            </dl>

            <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600 grid grid-cols-2 sm:grid-cols-4 gap-x-4 gap-y-1.5">
                <div>
                    <div class="text-gray-400">Tramo</div>
                    <div class="font-semibold" x-text="'Gs. ' + formatearGs(resultado?.tramo?.desde) + ' a Gs. ' + formatearGs(resultado?.tramo?.hasta)"></div>
                </div>
                <div>
                    <div class="text-gray-400">Excedente</div>
                    <div class="font-semibold" x-text="'Gs. ' + formatearGs(resultado?.excedente)"></div>
                </div>
                <div>
                    <div class="text-gray-400">Porcentaje</div>
                    <div class="font-semibold" x-text="resultado?.tramo?.porcentaje + '%'"></div>
                </div>
                <div>
                    <div class="text-gray-400">Adicional fijo</div>
                    <div class="font-semibold" x-text="'Gs. ' + formatearGs(resultado?.tramo?.adicional)"></div>
                </div>
            </div>
            <p class="mt-2 text-xs font-mono text-gray-500">
                Imp. Pat. (<span x-text="formatearGs(resultado?.monto)"></span>
                − <span x-text="formatearGs(resultado?.tramo?.desde)"></span>)
                × <span x-text="resultado?.tramo?.porcentaje"></span>%
                ** Adicional de Gs.: <span x-text="formatearGs(resultado?.tramo?.adicional)"></span>
                = <span class="font-bold text-gray-700" x-text="formatearGs(resultado?.impuesto)"></span>
            </p>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <p class="text-[11px] font-bold uppercase tracking-wide text-gray-400 px-6 pt-4 pb-1">Escala de tramos vigente</p>
            <table class="min-w-full text-xs">
                <thead class="bg-gray-50 text-gray-500 uppercase tracking-wide text-[10px]">
                    <tr>
                        <th class="px-6 py-1.5 text-left">Desde (Gs.)</th>
                        <th class="px-6 py-1.5 text-left">Hasta (Gs.)</th>
                        <th class="px-6 py-1.5 text-right">Porcentaje</th>
                        <th class="px-6 py-1.5 text-right">Adicional (Gs.)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tramos as $tramo)
                        @php
                            $condicion = $loop->last
                                ? "montoNumerico !== null && montoNumerico >= {$tramo->monto_desde}"
                                : "montoNumerico !== null && montoNumerico >= {$tramo->monto_desde} && montoNumerico < {$tramo->monto_hasta}";
                        @endphp
                        <tr :class="{{ $condicion }} ? 'bg-indigo-50 font-bold text-indigo-700' : 'text-gray-600'">
                            <td class="px-6 py-1.5 tabular-nums">{{ number_format($tramo->monto_desde, 0, ',', '.') }}</td>
                            <td class="px-6 py-1.5 tabular-nums">
                                @if ($loop->last)
                                    En adelante
                                @else
                                    {{ number_format($tramo->monto_hasta, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-6 py-1.5 text-right tabular-nums">{{ rtrim(rtrim(number_format($tramo->porcentaje, 2, ',', '.'), '0'), ',') }}%</td>
                            <td class="px-6 py-1.5 text-right tabular-nums">{{ number_format($tramo->adicional, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.public>
