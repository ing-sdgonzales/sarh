<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-gray-100 dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    {{ $modo_edicion ? 'Editar registro' : 'Nuevo registro' }}
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModal'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6 dark:text-gray-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <div class="relative p-4">
                <form id="candidatoForm" method="POST" wire:submit='guardar'>
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 dark:border-gray-500 pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-200">Información
                                personal</h2>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">
                                <div class="sm:col-span-6 mx-auto">
                                    <div class="mb-3" x-data="{ isUploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <div class="mb-4">
                                            @if ($imagen == true && $imagen_actual == '')
                                                <img src="{{ $imagen->temporaryUrl() }}"
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px;"
                                                    alt="imagen" />
                                            @elseif($imagen_control == true && $modo_edicion == true)
                                                <img @if ($imagen_actual != $imagen) src="{{ $imagen->temporaryUrl() }}"
                                                @else
                                                src="{{ asset('storage') . '/' . $imagen }}" @endif
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px;"
                                                    alt="imagen" />
                                            @else
                                                <img src="{{ url('/') }}/img/default.png"
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px;"
                                                    alt="imagen" />
                                            @endif
                                        </div>
                                        <input wire:model='imagen' id="imagen" accept=".jpg, .jpeg, .png"
                                            class="relative m-0 block w-full sm:w-auto min-w-0 flex-auto rounded-md border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                            type="file" id="imagen" style="width: 357.33px;" />
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
                                    <x-label for="dpi" value="{{ __('DPI') }}" />
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

                                <div class="sm:col-span-3">
                                    <x-label for="nombre" value="{{ __('Nombre completo') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='nombre' type="text" name="nombre" id="nombre"
                                            required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="email" value="{{ __('Correo electrónico') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='email' type="email" name="email" id="email"
                                            required class="block w-full" />
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
                                            max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                            name="fecha_de_nacimiento" id="fecha_nacimiento" required
                                            class="block w-full" />
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
                                        <x-select wire:model='estado_civil' id="estado_civil" name="estado_civil"
                                            required class="block w-full">
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
                                    <x-label for="fecha_registro" value="{{ __('Fecha de registgro') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_registro' type="date" name="fecha_de_registro"
                                            id="fecha_registro" readonly disabled class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_registro')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <x-label for="direccion_domicilio" value="{{ __('Dirección') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='direccion_domicilio' type="text" name="dirección"
                                            id="direccion_domicilio" required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('direccion_domicilio')
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

                                <div class="sm:col-span-3">
                                    <x-label for="departamento_origen" value="{{ __('Departamento') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='departamento_origen'
                                            wire:change='getMunicipiosByDepartamento' id="departamento_origen"
                                            name="departamento_origen" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos_origen ?? [] as $departamento)
                                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}
                                                </option>_origen
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('departamento_origen')
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

                        <div class="border-b border-gray-900/10 dark:border-gray-500 pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-200">Información
                                académica</h2>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">

                                <div class="sm:col-span-1">
                                    <x-label for="registro_academico" value="{{ __('Registro académico') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='registro_academico' id="registro_academico"
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
                                        <x-input wire:model='titulo' type="text" name="título" id="titulo"
                                            required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="registro_academico_estado" value="{{ __('Estado') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='registro_academico_estado'
                                            id="registro_academico_estado" name="registro_académico" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            <option value="1">En curso</option>
                                            <option value="2">Finalizado</option>
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('registro_academico_estado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="colegio" value="{{ __('Colegio') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='colegio' id="colegio" name="colegio"
                                            class="block w-full">
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

                                <div class="sm:col-span-3">
                                    <x-label for="colegiado" value="{{ __('Colegiado') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='colegiado' type="number" name="colegiado"
                                            id="colegiado" class="block w-full" />
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

                        <div class="pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-200">Información
                                laboral</h2>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">

                                <div class="sm:col-span-2">
                                    <x-label for="tipo_contratacion" value="{{ __('Tipo de contratación') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='tipo_contratacion' id="tipo_contratacion"
                                            name="tipo_contratación" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_contrataciones ?? [] as $contratacion)
                                                <option value="{{ $contratacion->id }}">
                                                    {{ $contratacion->tipo }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_contratacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="tipo_servicio" value="{{ __('Tipo de servicio') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='tipo_servicio' wire:change='getPuestosByTipoServicio'
                                            id="tipo_servicio" name="tipo_servicio" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_servicios ?? [] as $servicio)
                                                <option value="{{ $servicio->id }}">
                                                    {{ $servicio->tipo_servicio }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_servicio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="fecha_aplicacion" value="{{ __('Fecha de aplicación') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_aplicacion' type="date"
                                            name="fecha_de_aplicación" id="fecha_aplicacion" readonly disabled
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_aplicacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-full">
                                    <x-label for="secretaria" value="{{ __('Secretaría') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='secretaria' wire:change='getSubsecretariasBySecretaria'
                                            id="secretaria" name="secretaria" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias as $dependencia)
                                                <option value="{{ $dependencia->id }}">
                                                    {{ $dependencia->dependencia }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('secretaria')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                @if ($subsecretarias)
                                    <div class="sm:col-span-full">
                                        <x-label for="subsecretaria" value="{{ __('Subsecretaría') }}" />
                                        <div class="mt-2">
                                            <x-select wire:model='subsecretaria'
                                                wire:change='getDireccionesBySubsecretaria' id="subsecretaria"
                                                name="subsecretaria" class="block w-full">
                                                <option value="">Seleccionar...</option>
                                                @foreach ($subsecretarias as $subsecretaria)
                                                    <option value="{{ $subsecretaria->id }}">
                                                        {{ $subsecretaria->dependencia }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('subsecretaria')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                @endif


                                @if (count($direcciones) > 0)
                                    <div class="sm:col-span-full">
                                        <x-label for="direccion" value="{{ __('Dirección') }}" />
                                        <div class="mt-2">
                                            <x-select wire:model='direccion'
                                                wire:change='getSubdireccionesByDireccion' id="direccion"
                                                name="direccion" class="block w-full">
                                                <option value="">Seleccionar...</option>
                                                @foreach ($direcciones as $direccion)
                                                    <option value="{{ $direccion->id }}">
                                                        {{ $direccion->dependencia }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('direccion')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (count($subdirecciones) > 0)
                                    <div class="sm:col-span-full">
                                        <x-label for="subdireccion" value="{{ __('Subdirección') }}" />
                                        <div class="mt-2">
                                            <x-select wire:model='subdireccion'
                                                wire:change='getDepartamentosBySubdireccion' id="subdireccion"
                                                name="subdireccion" class="block w-full">
                                                <option value="">Seleccionar...</option>
                                                @foreach ($subdirecciones as $subdireccion)
                                                    <option value="{{ $subdireccion->id }}">
                                                        {{ $subdireccion->dependencia }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('subdireccion')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                @endif


                                @if (count($departamentos) > 0)
                                    <div class="sm:col-span-full">
                                        <x-label for="departamento" value="{{ __('Departamento') }}" />
                                        <div class="mt-2">
                                            <x-select wire:model='departamento'
                                                wire:change='getDelegacionesByDepartamento' id="departamento"
                                                name="departamento" class="block w-full">
                                                <option value="">Seleccionar...</option>
                                                @foreach ($departamentos as $departamento)
                                                    <option value="{{ $departamento->id }}">
                                                        {{ $departamento->dependencia }}
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
                                @endif

                                @if (count($delegaciones) > 0)
                                    <div class="sm:col-span-full">
                                        <x-label for="delegacion" value="{{ __('Delegación') }}" />
                                        <div class="mt-2">
                                            <x-select wire:model='delegacion' id="delegacion" name="delegacion"
                                                class="block w-full">
                                                <option value="">Seleccionar...</option>
                                                @foreach ($delegaciones as $delegacion)
                                                    <option value="{{ $delegacion->id }}">
                                                        {{ $delegacion->dependencia }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                        <div>
                                            <span class="text-red-600 text-sm">
                                                @error('delegacion')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="sm:col-span-full">
                                    <x-label for="puesto" value="{{ __('Puesto') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='puesto' id="puesto" name="puesto" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($puestos ?? [] as $psto)
                                                <option value="{{ $psto->id }}">
                                                    {{ $psto->codigo }} - {{ $psto->puesto }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-label for="observacion" value="{{ __('Observación') }}" />
                                    <div class="mt-2">
                                        <x-textarea wire:model='observacion' id="observacion" name="observación"
                                            rows="3" class="block w-full"></x-textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 dark:text-gray-200 text-gray-600">Breve
                                        descripción para la
                                        contratación.</p>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('observacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Modal footer-->
            <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                <button type="button" wire:click='cerrarModal'
                    class="inline-block rounded-lg bg-danger-200 px-6 pb-2 pt-2.5 font-medium leading-normal text-danger-700 transition duration-150 ease-in-out hover:bg-red-400 focus:bg-red-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" form="candidatoForm"
                    class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </div>
</div>
