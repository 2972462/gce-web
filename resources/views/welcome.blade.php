<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCE — Grupo Comercial Empresarial | Ciudad del Este, Paraguay</title>
    <meta name="description" content="Soluciones tecnológicas, desarrollo de software y provisión de insumos para instituciones públicas y privadas en Paraguay. Proveedor habilitado DNCP.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @if (config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endif

    @vite(['resources/css/app.css'])

    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .bg-grid {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.08) 1px, transparent 0);
            background-size: 32px 32px;
        }
        .text-balance { text-wrap: balance; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased">

<!-- NAV -->
<header x-data="{ open: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
        :class="scrolled ? 'bg-slate-900/95 backdrop-blur border-slate-800' : 'bg-slate-900 border-transparent'"
        class="fixed top-0 inset-x-0 z-50 border-b transition-colors">
    <nav class="max-w-7xl mx-auto px-6 h-18 py-3 flex items-center justify-between">
        <a href="#inicio" class="flex items-center gap-3">
            <img src="{{ $siteSetting->logoIzquierdoUrl() }}" alt="GCE — Grupo Comercial Empresarial" class="h-11 w-auto">
            <div class="leading-tight">
                <div class="text-white font-bold text-sm tracking-tight">Grupo Comercial Empresarial</div>
                <div class="text-amber-400/90 text-[10px] font-semibold tracking-[0.2em] uppercase">Ciudad del Este · Paraguay</div>
            </div>
        </a>

        <div class="hidden md:flex items-center gap-8">
            <a href="#nosotros" class="text-sm font-medium text-slate-300 hover:text-white transition">Nosotros</a>
            <a href="#servicios" class="text-sm font-medium text-slate-300 hover:text-white transition">Servicios</a>
            <a href="#calculadora" class="text-sm font-medium text-slate-300 hover:text-white transition">Herramientas</a>
            <a href="#licitaciones" class="text-sm font-medium text-slate-300 hover:text-white transition">Licitaciones</a>
            <a href="#contacto" class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition">Contacto</a>
            @if ($siteSetting->logoDerechoUrl())
                <img src="{{ $siteSetting->logoDerechoUrl() }}" alt="" class="h-9 w-auto ml-2">
            @endif
        </div>

        <button @click="open = !open" class="md:hidden text-white p-2">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </nav>

    <div x-show="open" x-transition style="display:none" class="md:hidden bg-slate-900 border-t border-slate-800 px-6 py-4 space-y-3">
        <a href="#nosotros" @click="open=false" class="block text-slate-300 font-medium">Nosotros</a>
        <a href="#servicios" @click="open=false" class="block text-slate-300 font-medium">Servicios</a>
        <a href="#calculadora" @click="open=false" class="block text-slate-300 font-medium">Herramientas</a>
        <a href="#licitaciones" @click="open=false" class="block text-slate-300 font-medium">Licitaciones</a>
        <a href="#contacto" @click="open=false" class="block text-amber-400 font-semibold">Contacto</a>
    </div>
</header>

<!-- HERO -->
<section id="inicio" class="relative bg-slate-900 pt-24 pb-6 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-grid opacity-40"></div>
    <div class="absolute -top-32 -right-32 w-[32rem] h-[32rem] bg-amber-500/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -left-32 w-[32rem] h-[32rem] bg-sky-500/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-5xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold tracking-widest uppercase mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
            Proveedor del Estado Paraguayo
        </div>

        <h1 class="text-balance text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.1]">
            Soluciones <span class="bg-gradient-to-r from-amber-400 to-amber-200 bg-clip-text text-transparent">tecnológicas</span>
            <br class="hidden sm:block"> para empresas e instituciones
        </h1>

        <p class="text-balance mt-5 text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
            Integramos tecnología, distribución y desarrollo de software para impulsar la eficiencia de organizaciones públicas y privadas en Paraguay.
        </p>

        <div class="mt-6 flex flex-wrap items-center justify-center gap-4">
            <a href="#servicios" class="px-6 py-3 rounded-xl bg-amber-500 text-slate-900 font-semibold text-sm hover:bg-amber-400 transition shadow-lg shadow-amber-500/20">
                Ver nuestros servicios
            </a>
            <a href="#contacto" class="px-6 py-3 rounded-xl border border-slate-700 text-white font-semibold text-sm hover:border-amber-400 hover:text-amber-400 transition">
                Solicitar cotización
            </a>
        </div>

        <div class="mt-6 grid grid-cols-3 gap-8 max-w-lg mx-auto pt-4 border-t border-slate-800">
            <div>
                <div class="text-2xl font-extrabold text-amber-400">3+</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide mt-1">Rubros de servicio</div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-amber-400">DNCP</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide mt-1">Proveedor registrado</div>
            </div>
            <div>
                <div class="text-2xl font-extrabold text-amber-400">CDE</div>
                <div class="text-xs text-slate-500 uppercase tracking-wide mt-1">Alto Paraná, Paraguay</div>
            </div>
        </div>
    </div>
</section>

<!-- HERRAMIENTAS: PATENTE + RUC -->
<section id="calculadora" class="pt-6 pb-16 px-6 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-5xl mx-auto">
        <div class="max-w-2xl mx-auto text-center mb-6">
            <div class="inline-flex items-center gap-2 text-xs font-bold tracking-widest text-sky-600 uppercase mb-3">
                <span class="w-7 h-0.5 bg-amber-500"></span> Herramientas gratuitas <span class="w-7 h-0.5 bg-amber-500"></span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight text-balance">
                Resolvé trámites al instante
            </h2>
            <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                Dos herramientas públicas, sin registro: calculá tu Patente Comercial y verificá un RUC paraguayo en segundos.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 items-start">
            <div id="calculadora-patente" class="bg-white rounded-2xl shadow-lg shadow-slate-900/5 border border-slate-200 p-6"
                 x-data="patenteCalculadora({{ Js::from($tramosParaJs) }})">
                <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-base mb-3">💰</div>
                <h3 class="font-bold text-slate-900 mb-1">Patente Comercial</h3>
                <p class="text-xs text-slate-500 mb-5">Cálculo según la Ley N° 135/91, con el detalle de las dos cuotas semestrales.</p>

                <div>
                    <label for="monto" class="block text-sm font-semibold text-slate-700 mb-1.5">Monto del activo declarado (Gs.)</label>
                    <div class="relative">
                        <input id="monto" name="monto" type="text" inputmode="numeric" :value="montoFormateado" @input="actualizarMonto($event)"
                               placeholder="15.000.000"
                               class="block w-full text-right tabular-nums pr-9 rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <button type="button" x-show="monto !== ''" x-cloak @click="monto = ''" title="Limpiar"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <div x-show="resultado" x-cloak class="mt-6 pt-5 border-t border-slate-200">
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400 mb-1">Total anual</div>
                            <div class="text-lg font-extrabold text-slate-900" x-text="'Gs. ' + formatearGs(resultado?.impuesto)"></div>
                        </div>
                        <div class="border-l border-slate-100 pl-3">
                            <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400 mb-1">1er semestre</div>
                            <div class="text-sm font-bold text-slate-700" x-text="'Gs. ' + formatearGs(resultado?.semestre1)"></div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400 mb-1">2do semestre</div>
                            <div class="text-sm font-bold text-slate-700" x-text="'Gs. ' + formatearGs(resultado?.semestre2)"></div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-3 text-xs text-slate-600 grid grid-cols-2 gap-x-3 gap-y-2">
                        <div>
                            <div class="text-slate-400">Tramo</div>
                            <div class="font-semibold" x-text="'Gs. ' + formatearGs(resultado?.tramo?.desde) + ' a Gs. ' + formatearGs(resultado?.tramo?.hasta)"></div>
                        </div>
                        <div>
                            <div class="text-slate-400">Excedente</div>
                            <div class="font-semibold" x-text="'Gs. ' + formatearGs(resultado?.excedente)"></div>
                        </div>
                        <div>
                            <div class="text-slate-400">Porcentaje</div>
                            <div class="font-semibold" x-text="resultado?.tramo?.porcentaje + '%'"></div>
                        </div>
                        <div>
                            <div class="text-slate-400">Adicional fijo</div>
                            <div class="font-semibold" x-text="'Gs. ' + formatearGs(resultado?.tramo?.adicional)"></div>
                        </div>
                    </div>
                    <p class="mt-2 text-[11px] font-mono text-slate-500">
                        Imp. Pat. (<span x-text="formatearGs(resultado?.monto)"></span>
                        − <span x-text="formatearGs(resultado?.tramo?.desde)"></span>)
                        × <span x-text="resultado?.tramo?.porcentaje"></span>%
                        ** Adicional de Gs.: <span x-text="formatearGs(resultado?.tramo?.adicional)"></span>
                        = <span class="font-bold text-slate-700" x-text="formatearGs(resultado?.impuesto)"></span>
                    </p>
                </div>

                <details class="mt-5 pt-4 border-t border-slate-200">
                    <summary class="text-[11px] font-bold uppercase tracking-wide text-slate-400 cursor-pointer select-none">Escala de tramos vigente</summary>
                    <div class="mt-3 -mx-6 px-6 overflow-x-auto">
                        <table class="w-full text-xs border-separate" style="border-spacing: 0;">
                            <thead class="text-slate-400 uppercase tracking-wide text-[10px]">
                                <tr>
                                    <th class="py-1.5 pr-3 text-left font-semibold">Tramo (Gs.)</th>
                                    <th class="py-1.5 px-3 text-right font-semibold">%</th>
                                    <th class="py-1.5 pl-3 text-right font-semibold">Adicional</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($tramos as $tramo)
                                    @php
                                        $condicion = $loop->last
                                            ? "montoNumerico !== null && montoNumerico >= {$tramo->monto_desde}"
                                            : "montoNumerico !== null && montoNumerico >= {$tramo->monto_desde} && montoNumerico < {$tramo->monto_hasta}";
                                    @endphp
                                    <tr :class="{{ $condicion }} ? 'bg-amber-50 font-bold text-amber-700' : 'text-slate-600'">
                                        <td class="py-1.5 pr-3 tabular-nums whitespace-nowrap">
                                            {{ number_format($tramo->monto_desde, 0, ',', '.') }}
                                            @if ($loop->last)
                                                en adelante
                                            @else
                                                – {{ number_format($tramo->monto_hasta, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td class="py-1.5 px-3 text-right tabular-nums whitespace-nowrap">{{ rtrim(rtrim(number_format($tramo->porcentaje, 2, ',', '.'), '0'), ',') }}%</td>
                                        <td class="py-1.5 pl-3 text-right tabular-nums whitespace-nowrap">{{ number_format($tramo->adicional, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
            </div>

            <div id="calculadora-ruc" class="bg-white rounded-2xl shadow-lg shadow-slate-900/5 border border-slate-200 p-6">
                <div class="w-9 h-9 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-base mb-3">🔎</div>
                <h3 class="font-bold text-slate-900 mb-1">Consulta de RUC</h3>
                <p class="text-xs text-slate-500 mb-5">Verificá la razón social y el estado de un RUC paraguayo.</p>

                <form id="home-ruc-form" method="POST" action="{{ route('publico.ruc.buscar') }}">
                    @csrf
                    <input type="hidden" name="recaptcha_token" id="home-recaptcha-token">

                    <div class="relative flex items-center bg-slate-50 border border-slate-300 rounded-full shadow-sm focus-within:border-sky-500 focus-within:ring-1 focus-within:ring-sky-500 overflow-hidden">
                        <svg class="w-4 h-4 ml-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3-3"/></svg>
                        <input id="consulta" name="consulta" type="text" value="{{ old('consulta', session('buscado') ?? '') }}"
                               placeholder="RUC o nombre/razón social"
                               class="flex-1 min-w-0 border-0 bg-transparent focus:ring-0 text-sm py-2.5 px-2.5">
                        <button type="submit" class="m-1 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-full hover:bg-sky-700 transition shrink-0">
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
                        <p class="mt-1.5 text-xs text-amber-600">reCAPTCHA sin configurar todavía.</p>
                    @endunless
                </form>

                @if (session('buscado'))
                    <div class="mt-6 pt-5 border-t border-slate-200">
                        @php $resultadosRuc = session('resultados', []); @endphp
                        @if (count($resultadosRuc) === 1)
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Nombre / Razón social</div>
                            <div class="text-base font-extrabold text-slate-900 mb-4">{{ \App\Services\RucBuscador::nombreLegible($resultadosRuc[0]['razon_social']) }}</div>
                            <div class="bg-slate-50 rounded-xl p-4 text-sm">
                                <div class="text-xs text-slate-500 mb-1">RUC</div>
                                <div class="font-bold text-slate-900">{{ $resultadosRuc[0]['ruc_completo'] }}</div>
                            </div>
                        @elseif (count($resultadosRuc) > 1)
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">{{ count($resultadosRuc) }} coincidencias</div>
                            @if (count($resultadosRuc) === \App\Services\RucBuscador::MAX_RESULTADOS_NOMBRE)
                                <p class="text-xs text-slate-400 mb-3">Mostrando las primeras {{ \App\Services\RucBuscador::MAX_RESULTADOS_NOMBRE }}. Agregá más datos (apellido, segundo nombre) para afinar la búsqueda.</p>
                            @else
                                <div class="mb-3"></div>
                            @endif
                            <ul class="space-y-2 max-h-72 overflow-y-auto">
                                @foreach ($resultadosRuc as $fila)
                                    <li class="bg-slate-50 rounded-xl p-3 text-sm">
                                        <div class="font-bold text-slate-900">{{ \App\Services\RucBuscador::nombreLegible($fila['razon_social']) }}</div>
                                        <div class="text-xs text-slate-500">RUC {{ $fila['ruc_completo'] }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-slate-600">No se encontraron resultados para <strong>{{ session('buscado') }}</strong>.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- TRUST STRIP -->
<div class="bg-slate-800 py-4 px-6 overflow-hidden border-b border-slate-700">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-x-10 gap-y-2 text-xs font-semibold text-slate-400 tracking-wide">
        <span>Sistemas CCTV y Videovigilancia</span>
        <span class="w-1 h-1 rounded-full bg-amber-500"></span>
        <span>Desarrollo de Software a Medida</span>
        <span class="w-1 h-1 rounded-full bg-amber-500"></span>
        <span>Insumos y Equipos para Oficina</span>
        <span class="w-1 h-1 rounded-full bg-amber-500"></span>
        <span>Proveedor habilitado DNCP</span>
    </div>
</div>

<!-- NOSOTROS -->
<section id="nosotros" class="py-28 px-6 bg-slate-50">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <div class="flex items-center gap-3 text-xs font-bold tracking-widest text-sky-600 uppercase mb-4">
                <span class="w-7 h-0.5 bg-amber-500"></span> Quiénes somos
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight text-balance">
                Compromiso con la tecnología y el desarrollo empresarial
            </h2>
            <p class="mt-6 text-slate-600 leading-relaxed">
                GCE — Grupo Comercial Empresarial es una empresa paraguaya con base en Ciudad del Este, especializada en la provisión de soluciones tecnológicas, desarrollo de software y suministros para instituciones públicas y privadas.
            </p>
            <p class="mt-4 text-slate-600 leading-relaxed">
                Nos distinguimos por nuestra capacidad de participar activamente en procesos de contratación pública, cumpliendo con todos los requisitos del sistema de la Dirección Nacional de Contrataciones Públicas (DNCP) de Paraguay.
            </p>
        </div>

        <div class="bg-slate-900 rounded-3xl p-10 relative overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 to-sky-500"></div>
            <div class="text-xs font-bold tracking-widest text-amber-400 uppercase mb-6">Nuestros valores</div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ([
                    ['icon' => '🎯', 'title' => 'Precisión', 'text' => 'Soluciones adaptadas a cada necesidad específica'],
                    ['icon' => '🤝', 'title' => 'Confianza', 'text' => 'Transparencia en cada proceso y contratación'],
                    ['icon' => '⚡', 'title' => 'Agilidad', 'text' => 'Respuesta rápida y entrega en tiempo y forma'],
                    ['icon' => '📈', 'title' => 'Crecimiento', 'text' => 'Acompañamos la evolución de nuestros clientes'],
                ] as $valor)
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:border-amber-500/30 transition">
                        <div class="text-xl mb-2">{{ $valor['icon'] }}</div>
                        <div class="font-bold text-white text-sm mb-1">{{ $valor['title'] }}</div>
                        <div class="text-xs text-slate-400 leading-relaxed">{{ $valor['text'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- SERVICIOS -->
<section id="servicios" class="py-28 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-16">
            <div>
                <div class="flex items-center gap-3 text-xs font-bold tracking-widest text-sky-600 uppercase mb-4">
                    <span class="w-7 h-0.5 bg-amber-500"></span> Nuestros servicios
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Lo que ofrecemos</h2>
            </div>
            <p class="text-slate-600 max-w-sm">Soluciones integrales para instituciones públicas, municipios, empresas y comercios del Paraguay.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                [
                    'icon' => '🎥', 'title' => 'Sistemas CCTV y Videovigilancia',
                    'text' => 'Diseño, suministro e instalación de sistemas de vigilancia y seguridad electrónica.',
                    'features' => ['Cámaras IP y analógicas HD/4K', 'NVR/DVR y almacenamiento en nube', 'Monitoreo remoto 24/7', 'Control de acceso biométrico'],
                ],
                [
                    'icon' => '💻', 'title' => 'Desarrollo de Software a Medida',
                    'text' => 'Sistemas de gestión, aplicaciones web y soluciones informáticas a medida.',
                    'features' => ['Sistemas de gestión municipal', 'Aplicaciones web y móvil', 'Integración con SIFEN / e-Kuatia', 'Soporte técnico especializado'],
                ],
                [
                    'icon' => '🖨️', 'title' => 'Insumos y Equipos para Oficina',
                    'text' => 'Provisión de insumos, consumibles y equipamiento de oficina.',
                    'features' => ['Cartuchos, tóners y consumibles', 'Impresoras y equipos multifunción', 'Equipos de cómputo y periféricos', 'Entrega con factura electrónica'],
                ],
            ] as $servicio)
                <div class="group rounded-2xl border border-slate-200 p-8 hover:border-slate-900 hover:shadow-xl hover:shadow-slate-900/5 transition">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        {{ $servicio['icon'] }}
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-3">{{ $servicio['title'] }}</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-5">{{ $servicio['text'] }}</p>
                    <ul class="space-y-2">
                        @foreach ($servicio['features'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-slate-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- LICITACIONES -->
<section id="licitaciones" class="py-28 px-6 bg-slate-900 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[32rem] h-[32rem] bg-sky-500/10 rounded-full blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold tracking-widest uppercase mb-6">
                ⚖️ Contrataciones Públicas
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight text-balance">
                Proveedor habilitado ante la DNCP
            </h2>
            <p class="mt-6 text-slate-400 leading-relaxed">
                GCE participa activamente en procesos de licitación pública, concursos de ofertas y contrataciones directas a través del Sistema de Información de Proveedores del Estado (SIPE) de Paraguay.
            </p>
            <a href="https://www.contrataciones.gov.py" target="_blank" class="mt-8 inline-flex items-center px-7 py-3.5 rounded-xl bg-amber-500 text-slate-900 font-semibold text-sm hover:bg-amber-400 transition">
                Consultar en DNCP →
            </a>
        </div>

        <div class="space-y-4">
            @foreach ([
                ['icon' => '📄', 'title' => 'Licitación Pública Nacional (LPN)', 'text' => 'Participamos en llamados nacionales para provisión de bienes y servicios tecnológicos.'],
                ['icon' => '🔖', 'title' => 'Menor Cuantía Nacional (MCN)', 'text' => 'Disponibles para contrataciones directas e inmediatas de menor escala.'],
                ['icon' => '📦', 'title' => 'Catálogo Electrónico / Tienda Virtual', 'text' => 'Productos disponibles para adquisición directa por organismos públicos.'],
                ['icon' => '🧾', 'title' => 'Facturación Electrónica SIFEN', 'text' => 'Emisión de facturas electrónicas conforme a la normativa de la SET.'],
            ] as $item)
                <div class="flex gap-4 bg-white/5 border border-white/10 rounded-2xl p-5 hover:border-amber-500/30 hover:bg-amber-500/5 transition">
                    <div class="text-2xl shrink-0">{{ $item['icon'] }}</div>
                    <div>
                        <div class="font-bold text-white text-sm mb-1">{{ $item['title'] }}</div>
                        <div class="text-sm text-slate-400 leading-relaxed">{{ $item['text'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- POR QUÉ ELEGIRNOS -->
<section class="py-28 px-6 bg-slate-50">
    <div class="max-w-3xl mx-auto text-center mb-16">
        <div class="flex items-center justify-center gap-3 text-xs font-bold tracking-widest text-sky-600 uppercase mb-4">
            <span class="w-7 h-0.5 bg-amber-500"></span> Por qué elegirnos <span class="w-7 h-0.5 bg-amber-500"></span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Ventajas que nos diferencian</h2>
    </div>

    <div class="max-w-7xl mx-auto grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ([
            ['icon' => '🏛️', 'title' => 'Experiencia institucional', 'text' => 'Conocimiento profundo de los procesos de contratación pública en Paraguay.'],
            ['icon' => '🛡️', 'title' => 'Registro limpio', 'text' => 'Sin antecedentes de inhabilitación. Empresa habilitada ante la DNCP y la DNIT.'],
            ['icon' => '📍', 'title' => 'Presencia regional', 'text' => 'Basados en Ciudad del Este, con atención en toda la región y el país.'],
            ['icon' => '🔧', 'title' => 'Soporte postventa', 'text' => 'Acompañamiento técnico después de cada entrega o implementación.'],
        ] as $ventaja)
            <div class="bg-white rounded-2xl border border-slate-200 p-7 text-center hover:border-slate-900 hover:shadow-lg transition">
                <div class="text-3xl mb-4">{{ $ventaja['icon'] }}</div>
                <div class="font-bold text-slate-900 text-sm mb-2">{{ $ventaja['title'] }}</div>
                <p class="text-xs text-slate-600 leading-relaxed">{{ $ventaja['text'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<!-- CONTACTO -->
<section id="contacto" class="py-28 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16">
        <div>
            <div class="flex items-center gap-3 text-xs font-bold tracking-widest text-sky-600 uppercase mb-4">
                <span class="w-7 h-0.5 bg-amber-500"></span> Hablemos
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Contacto</h2>
            <p class="mt-6 text-slate-600 leading-relaxed">
                Para cotizaciones, consultas sobre licitaciones o propuestas de trabajo, no dude en comunicarse con nosotros.
            </p>

            <div class="mt-10 space-y-6">
                @foreach ([
                    ['icon' => '📍', 'label' => 'Dirección', 'value' => 'Ciudad del Este, Alto Paraná, Paraguay'],
                    ['icon' => '📧', 'label' => 'Correo electrónico', 'value' => 'info@gce.com.py', 'href' => 'mailto:info@gce.com.py'],
                    ['icon' => '🕒', 'label' => 'Horario de atención', 'value' => 'Lun – Sáb: 7:00 – 17:00'],
                    ['icon' => '🌐', 'label' => 'Sitio web', 'value' => 'www.gce.com.py', 'href' => 'https://www.gce.com.py'],
                ] as $item)
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-lg shrink-0">
                            {{ $item['icon'] }}
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-0.5">{{ $item['label'] }}</div>
                            @if (isset($item['href']))
                                <a href="{{ $item['href'] }}" class="text-slate-900 font-semibold hover:text-amber-600 transition">{{ $item['value'] }}</a>
                            @else
                                <div class="text-slate-900 font-semibold">{{ $item['value'] }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-50 rounded-3xl border border-slate-200 p-8">
            <h3 class="font-bold text-slate-900 mb-6">Enviar consulta</h3>
            <form action="https://formsubmit.co/corporativogce@gmail.com" method="POST" class="space-y-5">
                <input type="hidden" name="_subject" value="Nueva consulta desde gce.com.py">
                <input type="hidden" name="_captcha" value="true">
                <input type="text" name="_honey" style="display:none">
                <input type="hidden" name="_template" value="table">
                <input type="hidden" name="_next" value="https://gce.com.py/?enviado=1">

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nombre</label>
                        <input type="text" name="nombre" placeholder="Su nombre completo" required
                               class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Institución / Empresa</label>
                        <input type="text" name="empresa" placeholder="Nombre de la organización"
                               class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Correo electrónico</label>
                    <input type="email" name="email" placeholder="correo@institución.com" required
                           class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tipo de consulta</label>
                    <select name="tipo_consulta" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">Seleccionar...</option>
                        <option>Cotización — CCTV y Videovigilancia</option>
                        <option>Cotización — Desarrollo de Software</option>
                        <option>Cotización — Insumos de Oficina</option>
                        <option>Consulta sobre licitaciones</option>
                        <option>Soporte técnico</option>
                        <option>Otro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mensaje</label>
                    <textarea name="mensaje" rows="4" placeholder="Describa su necesidad o consulta..." required
                              class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                </div>

                <div class="g-recaptcha" data-sitekey="6Lfv14UsAAAAAMyy5ERbsmgShEbT0tvKMHdnebgf"></div>

                <button type="submit" class="w-full px-6 py-3.5 rounded-xl bg-slate-900 text-white font-semibold text-sm hover:bg-slate-800 transition">
                    Enviar consulta
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ACCESOS A OTROS SISTEMAS -->
<section class="py-16 px-6 bg-slate-100 border-y border-slate-200">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
            <div class="text-xs font-bold tracking-widest text-slate-500 uppercase mb-2">Accesos</div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sistemas internos del grupo</h2>
        </div>
        <div class="grid sm:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <a href="https://erp.gce.com.py" target="_blank" rel="noopener"
               class="group flex items-center gap-4 bg-white rounded-2xl border border-slate-200 p-6 hover:border-slate-900 hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-xl shrink-0">
                    🗂️
                </div>
                <div>
                    <div class="font-bold text-slate-900">Sistema ERP</div>
                    <div class="text-sm text-slate-500">erp.gce.com.py</div>
                </div>
                <svg class="w-4 h-4 ml-auto text-slate-400 group-hover:text-slate-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="https://muni.gce.com.py" target="_blank" rel="noopener"
               class="group flex items-center gap-4 bg-white rounded-2xl border border-slate-200 p-6 hover:border-slate-900 hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-xl shrink-0">
                    🏛️
                </div>
                <div>
                    <div class="font-bold text-slate-900">Portal Municipal</div>
                    <div class="text-sm text-slate-500">muni.gce.com.py</div>
                </div>
                <svg class="w-4 h-4 ml-auto text-slate-400 group-hover:text-slate-900 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-slate-950 pt-20 pb-10 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12 pb-12 border-b border-slate-800">
        <div class="md:col-span-1">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ $siteSetting->logoIzquierdoUrl() }}" alt="GCE — Grupo Comercial Empresarial" class="h-10 w-auto">
                <div class="text-white font-bold text-sm">Grupo Comercial Empresarial</div>
            </div>
            <p class="text-sm text-slate-500 leading-relaxed">
                Empresa paraguaya especializada en soluciones tecnológicas, desarrollo de software, CCTV y provisión de insumos para el sector público y privado.
            </p>
        </div>

        <div>
            <div class="text-xs font-bold text-white uppercase tracking-widest mb-5">Servicios</div>
            <ul class="space-y-3 text-sm text-slate-500">
                <li><a href="#servicios" class="hover:text-amber-400 transition">Sistemas CCTV</a></li>
                <li><a href="#servicios" class="hover:text-amber-400 transition">Desarrollo de Software</a></li>
                <li><a href="#servicios" class="hover:text-amber-400 transition">Insumos de Oficina</a></li>
                <li><a href="#licitaciones" class="hover:text-amber-400 transition">Licitaciones Públicas</a></li>
            </ul>
        </div>

        <div>
            <div class="text-xs font-bold text-white uppercase tracking-widest mb-5">Empresa</div>
            <ul class="space-y-3 text-sm text-slate-500">
                <li><a href="#nosotros" class="hover:text-amber-400 transition">Quiénes somos</a></li>
                <li><a href="#calculadora-patente" class="hover:text-amber-400 transition">Calculadora de Patente</a></li>
                <li><a href="#calculadora-ruc" class="hover:text-amber-400 transition">Consulta de RUC</a></li>
                <li><a href="#contacto" class="hover:text-amber-400 transition">Contacto</a></li>
            </ul>
        </div>

        <div>
            <div class="text-xs font-bold text-white uppercase tracking-widest mb-5">Normativa</div>
            <ul class="space-y-3 text-sm text-slate-500">
                <li><a href="https://www.contrataciones.gov.py" target="_blank" class="hover:text-amber-400 transition">Portal DNCP</a></li>
                <li><a href="https://www.set.gov.py" target="_blank" class="hover:text-amber-400 transition">DNIT Paraguay</a></li>
                <li><a href="https://ekuatia.set.gov.py" target="_blank" class="hover:text-amber-400 transition">SIFEN / e-Kuatia</a></li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pt-8 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-500">
        <div>&copy; {{ now()->year }} GCE — Grupo Comercial Empresarial. Todos los derechos reservados.</div>
        <div class="flex gap-6">
            <a href="#" class="hover:text-amber-400 transition">Política de privacidad</a>
            <a href="#" class="hover:text-amber-400 transition">Términos de uso</a>
        </div>
    </div>
</footer>

@if (config('services.recaptcha.site_key'))
    <script>
        document.getElementById('home-ruc-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'consulta_ruc' }).then(function (token) {
                    document.getElementById('home-recaptcha-token').value = token;
                    form.submit();
                });
            });
        });
    </script>
@endif

@vite(['resources/js/app.js'])
</body>
</html>
