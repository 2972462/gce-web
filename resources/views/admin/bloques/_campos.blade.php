@php($contenido = $contenido ?? [])

@switch($tipo)
    @case('texto')
        <div>
            <x-input-label for="contenido_titulo" :value="__('Título (opcional)')" />
            <x-text-input id="contenido_titulo" name="contenido[titulo]" type="text" class="mt-1 block w-full" value="{{ old('contenido.titulo', $contenido['titulo'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.titulo')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_cuerpo" :value="__('Texto')" />
            <textarea id="contenido_cuerpo" name="contenido[cuerpo]" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('contenido.cuerpo', $contenido['cuerpo'] ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('contenido.cuerpo')" class="mt-2" />
        </div>
        @break

    @case('imagen')
        <div>
            <x-input-label for="contenido_url" :value="__('URL de la imagen')" />
            <x-text-input id="contenido_url" name="contenido[url]" type="text" class="mt-1 block w-full" value="{{ old('contenido.url', $contenido['url'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.url')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_alt" :value="__('Texto alternativo')" />
            <x-text-input id="contenido_alt" name="contenido[alt]" type="text" class="mt-1 block w-full" value="{{ old('contenido.alt', $contenido['alt'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.alt')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_caption" :value="__('Pie de imagen (opcional)')" />
            <x-text-input id="contenido_caption" name="contenido[caption]" type="text" class="mt-1 block w-full" value="{{ old('contenido.caption', $contenido['caption'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.caption')" class="mt-2" />
        </div>
        @break

    @case('tarjeta')
        <div>
            <x-input-label for="contenido_icono" :value="__('Icono (opcional)')" />
            <x-text-input id="contenido_icono" name="contenido[icono]" type="text" class="mt-1 block w-full" value="{{ old('contenido.icono', $contenido['icono'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.icono')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_titulo" :value="__('Título')" />
            <x-text-input id="contenido_titulo" name="contenido[titulo]" type="text" class="mt-1 block w-full" value="{{ old('contenido.titulo', $contenido['titulo'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.titulo')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_descripcion" :value="__('Descripción')" />
            <textarea id="contenido_descripcion" name="contenido[descripcion]" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('contenido.descripcion', $contenido['descripcion'] ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('contenido.descripcion')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_link" :value="__('Link (opcional)')" />
            <x-text-input id="contenido_link" name="contenido[link]" type="text" class="mt-1 block w-full" value="{{ old('contenido.link', $contenido['link'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.link')" class="mt-2" />
        </div>
        @break

    @case('boton')
        <div>
            <x-input-label for="contenido_texto" :value="__('Texto del botón')" />
            <x-text-input id="contenido_texto" name="contenido[texto]" type="text" class="mt-1 block w-full" value="{{ old('contenido.texto', $contenido['texto'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.texto')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_url" :value="__('URL')" />
            <x-text-input id="contenido_url" name="contenido[url]" type="text" class="mt-1 block w-full" value="{{ old('contenido.url', $contenido['url'] ?? '') }}" />
            <x-input-error :messages="$errors->get('contenido.url')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-input-label for="contenido_estilo" :value="__('Estilo')" />
            <select id="contenido_estilo" name="contenido[estilo]" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                @foreach (['primario' => __('Primario'), 'secundario' => __('Secundario')] as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected(old('contenido.estilo', $contenido['estilo'] ?? '') === $valor)>{{ $etiqueta }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('contenido.estilo')" class="mt-2" />
        </div>
        @break
@endswitch
