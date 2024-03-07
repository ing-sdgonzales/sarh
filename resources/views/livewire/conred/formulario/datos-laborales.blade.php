<div>
    <div class="relative p-4">
        <form wire:submit='guardarDatosLaborales'>
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 dark:border-b-gray-600 pb-6">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Información acádemica</h2>
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-full">
                            <x-label for=dpi value="{{ __('DPI') }}" />
                            <div class="mt-2">
                                <x-input wire:model='dpi' type="text" name="dpi" id="dpi" required
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('dpi')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="registro_academico" value="{{ __('Registro académico') }}" />
                            <div class="mt-2">
                                <x-select wire:model.live='registro_academico' id="registro_academico"
                                    name="registro_académico" required class="block w-full">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($registros_academicos ?? [] as $registro_academico)
                                        <option value="{{ $registro_academico->id }}">
                                            {{ $registro_academico->nivel }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('registro_academico')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <x-label for="titulo" value="{{ __('Título') }}" />
                            <div class="mt-2">
                                <x-input wire:model.live='titulo' type="text" name="título" id="titulo" required
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('titulo')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <x-label for="colegio" value="{{ __('Colegio') }}" />
                            <div class="mt-2">
                                <x-select wire:model='colegio' id="colegio" name="colegio" class="block w-full">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($colegios ?? [] as $colegio)
                                        <option value="{{ $colegio->id }}">
                                            {{ $colegio->nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('colegio')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <x-label for="titulo_universitario" value="{{ __('Título universitario') }}" />
                            <div class="mt-2">
                                <x-input wire:model='titulo_universitario' type="text" id="titulo_universitario"
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('titulo_universitario')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="colegiado" value="{{ __('Colegiado') }}" />
                            <div class="mt-2">
                                <x-input wire:model='colegiado' type="number" name="colegiado" id="colegiado"
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('colegiado')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-x-2 mt-2 justify-end">
                <x-button type="submit">{{ __('Guardar') }}</x-button>
                @if ($finalizar)
                    <x-button type="button"
                        class="bg-success dark:bg-success hover:bg-success-900 dark:hover:bg-success-900"
                        wire:click="completarFormulario">{{ __('Finaliazar') }}</x-button>
                @endif
            </div>
        </form>
    </div>
</div>
