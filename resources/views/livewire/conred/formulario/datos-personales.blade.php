<div>
    <div class="relative p-4">
        <form wire:submit='guardarDatosPersonales'>
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 dark:border-b-gray-600 pb-6">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Información personal</h2>
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">
                        <div class="sm:col-span-6 mx-auto">
                            <div class="mb-3" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="mb-4">
                                    @if ($imagen == true)
                                        <img src="{{ $imagen->temporaryUrl() }}" class="mx-auto max-w-full rounded-lg"
                                            style="height: 150px;" alt="imagen" />
                                    @else
                                        <img src="{{ url('/') }}/img/default.png"
                                            class="mx-auto max-w-full rounded-lg" style="height: 150px;"
                                            alt="imagen" />
                                    @endif
                                </div>
                                <input wire:model='imagen' id="imagen" accept=".jpg, .jpeg, .png"
                                    class="relative m-0 block w-full sm:w-auto min-w-0 flex-auto rounded-md border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                    type="file" id="imagen" style="width: 357.33px;" required />
                                <!-- Progress Bar -->
                                <div x-show="isUploading" class="mt-2">
                                    <progress max="100" x-bind:value="progress"
                                        class="w-full h-2 bg-blue-500"></progress>
                                    <p class="mt-2 text-sm font-semibold text-gray-700 dark:text-gray-200"
                                        x-text="'Cargando: ' + progress + '%'"></p>
                                </div>
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('imagen')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-2">
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
                            <x-label for="nit" value="{{ __('NIT') }}" />
                            <div class="mt-2">
                                <x-input wire:model='nit' type="text" name="nit" id="nit" required
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('nit')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="igss" value="{{ __('IGSS') }}" />
                            <div class="mt-2">
                                <x-input wire:model='igss' type="text" name="igss" id="igss"
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('igss')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <x-label for="nombre" value="{{ __('Nombre completo') }}" />
                            <div class="mt-2">
                                <x-input wire:model='nombre' type="text" name="nombre" id="nombre" required
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('nombre')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <x-label for="email" value="{{ __('Correo electrónico') }}" />
                            <div class="mt-2">
                                <x-input wire:model='email' type="email" name="email" id="email" required
                                    class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="fecha_nacimiento" value="{{ __('Fecha de nacimiento') }}" />
                            <div class="mt-2">
                                <x-input wire:model='fecha_nacimiento' type="date"
                                    max="{{ now()->subYears(18)->format('Y-m-d') }}" name="fecha_de_nacimiento"
                                    id="fecha_nacimiento" required class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('fecha_nacimiento')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="estado_civil" value="{{ __('Estado civil') }}" />
                            <div class="mt-2">
                                <x-select wire:model='estado_civil' id="estado_civil" name="estado_civil" required
                                    class="block w-full">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($estados_civiles ?? [] as $estado_civil)
                                        <option value="{{ $estado_civil->id }}">
                                            {{ $estado_civil->estado_civil }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('estado_civil')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="telefono" value="{{ __('Teléfono') }}" />
                            <div class="mt-2">
                                <x-input wire:model='telefono' type="text" name="teléfono" id="telefono"
                                    required class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('telefono')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-full">
                            <x-label for="direccion" value="{{ __('Dirección') }}" />
                            <div class="mt-2">
                                <x-input wire:model='direccion' type="text" name="dirección" id="direccion"
                                    required class="block w-full" />
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('direccion')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-label for="departamento" value="{{ __('Departamento') }}" />
                            <div class="mt-2">
                                <x-select wire:model='departamento' wire:change='getMunicipiosByDepartamento'
                                    id="departamento" name="departamento" required class="block w-full">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($departamentos ?? [] as $departamento)
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('departamento')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-label for="municipio" value="{{ __('Municipio') }}" />
                            <div class="mt-2">
                                <x-select wire:model='municipio' id="municipio" name="municipio" required
                                    class="block w-full">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($municipios ?? [] as $municipio)
                                        <option value="{{ $municipio->id }}">{{ $municipio->nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div>
                                <span class="text-red-600 text-sm">
                                    @error('municipio')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex mt-2 justify-end">
                <x-button type="submit">{{ __('Guardar') }}</x-button>
            </div>
        </form>
    </div>
</div>
