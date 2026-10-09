<x-layouts.public :titulo="'Cálculo de Patente Comercial'">
    <div class="bg-white shadow-sm rounded-lg p-6 sm:p-8">
        <h1 class="text-2xl font-semibold text-gray-900">Cálculo de Patente Comercial</h1>
        <p class="mt-2 text-gray-600">Ingresa el monto del activo declarado para calcular el impuesto de Patente Comercial (Ley N° 135/91).</p>

        <form method="POST" action="{{ route('publico.patente.calcular') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700">Monto del activo declarado (Gs.)</label>
                <input id="monto" name="monto" type="text" inputmode="numeric" value="{{ old('monto') }}"
                       placeholder="15.000.000"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('monto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Calcular
            </button>
        </form>

        @if ($resultado = session('resultado'))
            <div class="mt-8 border-t border-gray-200 pt-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-sm">
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500">Impuesto total</dt>
                        <dd class="text-2xl font-semibold text-gray-900">Gs. {{ number_format($resultado['impuesto'], 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">1ra cuota (semestral)</dt>
                        <dd class="font-medium text-gray-900">Gs. {{ number_format($resultado['semestre1'], 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">2da cuota (semestral)</dt>
                        <dd class="font-medium text-gray-900">Gs. {{ number_format($resultado['semestre2'], 0, ',', '.') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500">Tramo aplicado</dt>
                        <dd class="font-medium text-gray-900">
                            Gs. {{ number_format($resultado['tramo']['monto_desde'], 0, ',', '.') }} a
                            Gs. {{ number_format($resultado['tramo']['monto_hasta'], 0, ',', '.') }}
                            ({{ number_format($resultado['tramo']['porcentaje'], 2, ',', '.') }}% + Gs. {{ number_format($resultado['tramo']['adicional'], 0, ',', '.') }})
                        </dd>
                    </div>
                </dl>
            </div>
        @endif
    </div>
</x-layouts.public>
