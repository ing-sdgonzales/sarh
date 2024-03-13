<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    Nuevo registro
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModal()'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <form method="POST" wire:submit='guardar'>
                @method('POST')
                @csrf
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">
                                <div class="sm:col-span-full rounded-lg bg-primary-100 text-xl text-center">
                                    <h1 class="p-2 font-semibold leading-7 text-gray-900">Fotografía
                                    </h1>
                                </div>
                                <div class="sm:col-span-6 mx-auto">
                                    <div class="mb-3" x-data="{ isUploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <div class="mb-4">

                                            @if ($imagen && !$imagen_actual)
                                                <img src="{{ $imagen->temporaryUrl() }}"
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px"
                                                    alt="imagen" />
                                            @elseif($imagen_actual)
                                                <img src="{{ asset('storage') . '/' . $imagen_actual }}"
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px"
                                                    alt="imagen" />
                                                {{-- @elseif($imagen_control == true && $modo_edicion == true)
                                                <img @if ($imagen_actual != $imagen) src="{{ $imagen->temporaryUrl() }}"
                                                @else
                                                src="{{ asset('storage') . '/' . $imagen }}" @endif
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px"
                                                    alt="imagen" /> --}}
                                            @else
                                                <img src="{{ url('/') }}/img/default.png"
                                                    class="mx-auto max-w-full rounded-lg" style="height: 150px"
                                                    alt="imagen" />
                                            @endif
                                        </div>
                                        <input wire:model='imagen' accept=".jpg, .jpeg, .png"
                                            class="relative m-0 block w-full sm:w-auto min-w-0 flex-auto rounded-md border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                            type="file" id="imagen" style="width: 357.33px" />
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading" class="mt-2">
                                            <progress max="100" x-bind:value="progress"
                                                class="w-full h-2 bg-blue-500"></progress>
                                            <p class="mt-2 text-sm font-semibold text-gray-700"
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
                        </div>
                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 font-semibold leading-7 text-gray-900">1. Datos generales
                                </h1>
                            </div>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="nombres"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombres</label>
                                    <div class="mt-2">
                                        <input wire:model='nombres' type="text" name="nombres" id="nombres"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombres')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="apellidos"
                                        class="block text-sm font-medium leading-6 text-gray-900">Apellidos</label>
                                    <div class="mt-2">
                                        <input wire:model='apellidos' type="text" name="apellidos" id="apellidos"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('apellidos')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="codigo"
                                        class="block text-sm font-medium leading-6 text-gray-900">Código de
                                        empleado</label>
                                    <div class="mt-2">
                                        <input wire:model='codigo' type="number" name="codigo" id="codigo" required
                                            pattern="^9[1-9]\d{7,}$" min="900000000" step="1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('codigo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="pretension_salarial"
                                        class="block text-sm font-medium leading-6 text-gray-900">Pretensión
                                        salarial</label>
                                    <div class="mt-2">
                                        <input wire:model='pretension_salarial' type="number"
                                            name="pretension_salarial" id="pretension_salarial" step="0.01"
                                            min="0" pattern="^\d+(\.\d{1,2})?$" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('pretension_salarial')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="relacion_laboral"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        empleado</label>
                                    <div class="mt-2">
                                        <select wire:model='relacion_laboral' id="relacion_laboral"
                                            name="relacion_laboral" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($relaciones_laborales ?? [] as $relacion_laboral)
                                                @if ($relacion_laboral->id == 4)
                                                    <option value="{{ $relacion_laboral->id }}" disabled>
                                                        {{ $relacion_laboral->relacion_laboral }}
                                                    </option>
                                                @else
                                                    <option value="{{ $relacion_laboral->id }}">
                                                        {{ $relacion_laboral->relacion_laboral }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('relacion_laboral')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">2. Datos del
                                    solicitante
                                </h1>
                            </div>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-6">
                                    <p class="mt-3 text-sm leading-6 text-gray-600"><strong>Lugar y fecha de
                                            nacimiento</strong></p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="departamento_origen"
                                        class="block text-sm font-medium leading-6 text-gray-900">Departamento</label>
                                    <div class="mt-2">
                                        <select wire:model='departamento_origen'
                                            wire:change='getMunicipiosByDepartamento' id="departamento_origen"
                                            name="departamento_origen" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos_origen ?? [] as $departamento)
                                                <option value="{{ $departamento->id }}">
                                                    {{ $departamento->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('departamento_origen')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="municipio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Municipio</label>
                                    <div class="mt-2">
                                        <select wire:model='municipio' id="municipio" name="municipio" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($municipios ?? [] as $municipio)
                                                <option value="{{ $municipio->id }}">{{ $municipio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('municipio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="fecha_nacimiento"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        nacimiento</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_nacimiento' type="date" name="fecha_nacimiento"
                                            id="fecha_nacimiento" required
                                            max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_nacimiento')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="nacionalidad"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nacionalidad</label>
                                    <div class="mt-2">
                                        <select wire:model='nacionalidad' id="nacionalidad" name="Nacionalidad"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($nacionalidades ?? [] as $nacionalidad)
                                                <option value="{{ $nacionalidad->id }}">
                                                    {{ $nacionalidad->nacionalidad }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nacionalidad')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="genero"
                                        class="block text-sm font-medium leading-6 text-gray-900">Género</label>
                                    <div class="mt-2">
                                        <select wire:model='genero' id="genero" name="genero" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($generos ?? [] as $genero)
                                                <option value="{{ $genero->id }}">
                                                    {{ $genero->genero }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('genero')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="estado_civil"
                                        class="block text-sm font-medium leading-6 text-gray-900">Estado
                                        civil</label>
                                    <div class="mt-2">
                                        <select wire:model='estado_civil' id="estado_civil" name="estado_civil"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($estados_civiles ?? [] as $estado_civil)
                                                <option value="{{ $estado_civil->id }}">
                                                    {{ $estado_civil->estado_civil }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('estado_civil')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="estado_familiar"
                                        class="block text-sm font-medium leading-6 text-gray-900">Estado
                                        familiar</label>
                                    <div class="mt-2">
                                        <select wire:model='estado_familiar' id="estado_familiar"
                                            name="estado_familiar"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($estados_familiares ?? [] as $ef)
                                                <option value="{{ $ef['val'] }}">
                                                    {{ $ef['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('estado_familiar')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="direccion_domicilio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Residencia
                                        actual</label>
                                    <div class="mt-2">
                                        <input wire:model='direccion_domicilio' type="text"
                                            name="direccion_domicilio" id="direccion_domicilio" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('direccion_domicilio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="departamento_residencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Departamento</label>
                                    <div class="mt-2">
                                        <select wire:model='departamento_residencia'
                                            wire:change='getMunicipiosByDepartamentoResidencia'
                                            id="departamento_residencia" name="departamento_residencia" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos_origen ?? [] as $departamento)
                                                <option value="{{ $departamento->id }}">
                                                    {{ $departamento->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('departamento_residencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="municipio_residencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Municipio</label>
                                    <div class="mt-2">
                                        <select wire:model='municipio_residencia' id="municipio_residencia"
                                            name="municipio_residencia" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($municipios_residencia ?? [] as $municipio_residencia)
                                                <option value="{{ $municipio_residencia->id }}">
                                                    {{ $municipio_residencia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('municipio_residencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="dpi"
                                        class="block text-sm font-medium leading-6 text-gray-900">DPI</label>
                                    <div class="mt-2">
                                        <input wire:model='dpi' type="text" name="dpi" id="dpi"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="departamento_emision"
                                        class="block text-sm font-medium leading-6 text-gray-900">Departamento de
                                        emisión</label>
                                    <div class="mt-2">
                                        <select wire:model='departamento_emision'
                                            wire:change='getMunicipiosByDepartamentoEmision' id="departamento_emision"
                                            name="departamento_emision" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos_origen ?? [] as $departamento)
                                                <option value="{{ $departamento->id }}">
                                                    {{ $departamento->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('departamento_emision')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="municipio_emision"
                                        class="block text-sm font-medium leading-6 text-gray-900">Municipio de
                                        emision</label>
                                    <div class="mt-2">
                                        <select wire:model='municipio_emision' id="municipio_emision"
                                            name="municipio_emision" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($municipios_emision ?? [] as $municipio)
                                                <option value="{{ $municipio->id }}">{{ $municipio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('municipio_emision')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="igss"
                                        class="block text-sm font-medium leading-6 text-gray-900">Número de
                                        afiliación IGSS</label>
                                    <div class="mt-2">
                                        <input wire:model='igss' type="text" name="igss" id="igss"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('igss')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nit"
                                        class="block text-sm font-medium leading-6 text-gray-900">NIT</label>
                                    <div class="mt-2">
                                        <input wire:model='nit' type="text" name="nit" id="nit"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="cuenta_banco"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cuenta de
                                        banco</label>
                                    <div class="mt-2">
                                        <input wire:model='cuenta_banco' type="text" name="cuenta_banco"
                                            id="cuenta_banco" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('cuenta_banco')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="licencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Número de
                                        licencia</label>
                                    <div class="mt-2">
                                        <input wire:model='licencia' type="text" name="licencia" id="licencia"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('licencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="tipo_licencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        licencia</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_licencia' id="tipo_licencia" name="tipo_licencia"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_licencias ?? [] as $tipo_licencia)
                                                <option value="{{ $tipo_licencia->id }}">
                                                    {{ $tipo_licencia->tipo_licencia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_licencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="tipo_vehiculo"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        vehículo</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_vehiculo' id="tipo_vehiculo" name="tipo_vehiculo"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_vehiculos ?? [] as $tipo_vehiculo)
                                                <option value="{{ $tipo_vehiculo->id }}">
                                                    {{ $tipo_vehiculo->tipo_vehiculo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_vehiculo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="placa"
                                        class="block text-sm font-medium leading-6 text-gray-900">Placa
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='placa' type="text" name="placa" id="placa"
                                            pattern="^[PM]\d{3}[BCDFGHJKLMNPQRSTVWXYZ]{3}$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('placa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_casa"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono de casa
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_casa' type="text" name="telefono_casa"
                                            id="telefono_casa"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('telefono_casa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_movil"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono móvil
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_movil' type="text" name="telefono_movil"
                                            id="telefono_movil" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('telefono_movil')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Correo
                                        electrónico</label>
                                    <div class="mt-2">
                                        <input wire:model='email' type="email" name="email" id="email"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">3. Datos
                                    familiares
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-2">
                                    <label for="familiar_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Tiene algún
                                        familiar laborando en CONRED?</label>
                                    <div class="mt-2">
                                        <select wire:model='familiar_conred' id="familiar_conred"
                                            name="familiar_conred" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('familiar_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_familiar_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_familiar_conred' type="text"
                                            name="nombre_familiar_conred" id="nombre_familiar_conred"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre_familiar_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_familiar_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='cargo_familiar_conred' type="text"
                                            name="cargo_familiar_conred" id="cargo_familiar_conred"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('cargo_familiar_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="conocido_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Conoce a alguien
                                        que labora en la institución?</label>
                                    <div class="mt-2">
                                        <select wire:model='conocido_conred' id="conocido_conred"
                                            name="conocido_conred" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('conocido_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_conocido_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_conocido_conred' type="text"
                                            name="nombre_conocido_conred" id="nombre_conocido_conred"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre_conocido_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_conocido_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='cargo_conocido_conred' type="text"
                                            name="cargo_conocido_conred" id="cargo_conocido_conred"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('cargo_conocido_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_padre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono del
                                        padre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_padre' type="text" name="telefono_padre"
                                            id="telefono_padre"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('telefono_padre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_padre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del padre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_padre' type="text" name="nombre_padre"
                                            id="nombre_padre" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre_padre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ocupacion_padre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ocupación del
                                        padre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='ocupacion_padre' type="text" name="ocupacion_padre"
                                            id="ocupacion_padre" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('ocupacion_padre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_madre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono de la
                                        madre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_madre' type="text" name="telefono_madre"
                                            id="telefono_madre"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('telefono_madre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_madre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre de la
                                        madre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_madre' type="text" name="nombre_madre"
                                            id="nombre_madre" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre_madre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ocupacion_madre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ocupación de la
                                        madre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='ocupacion_madre' type="text" name="ocupacion_madre"
                                            id="ocupacion_madre" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('ocupacion_madre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_conviviente"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono del
                                        esposo(a) o conviviente
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_conviviente' type="text"
                                            name="telefono_conviviente" id="telefono_conviviente"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('telefono_conviviente')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_conviviente"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del
                                        esposo(a) o conviviente
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_conviviente' type="text"
                                            name="nombre_conviviente" id="nombre_conviviente"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre_conviviente')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ocupacion_conviviente"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ocupación del
                                        esposo(a) o conviviente
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='ocupacion_conviviente' type="text"
                                            name="ocupacion_conviviente" id="ocupacion_conviviente"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('ocupacion_conviviente')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">Nombres y
                                        apellidos de sus hijos</label>
                                    @foreach ($hijos as $index => $hijo)
                                        <div class="sm:col-span-5 flex items-center">
                                            <div class="mt-2 flex-grow">
                                                <input wire:model='hijos.{{ $index }}.nombre' type="text"
                                                    id="hijo_{{ $index }}"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('hijos.{{ $index }}.nombre')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            @if ($index === 0)
                                                <div class="mt-2 ml-2">
                                                    <button class="btn text-black btn-info btn-sm"
                                                        wire:click.prevent="add_son()"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-2 ml-2">
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click.prevent="remove_son({{ $index }})"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 12h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">4. Información
                                    académica
                                </h1>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-2 text-center">
                                    <label
                                        class="mt-6 block font-medium leading-6 text-gray-900 align-text-bottom">Primaria</label>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="establecimiento_primaria"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_primaria' type="text"
                                            name="establecimiento_primaria" id="establecimiento_primaria" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_primaria')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_primaria"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_primaria' type="text" name="titulo_primaria"
                                            id="titulo_primaria" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo_primaria')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2 text-center">
                                    <label
                                        class="mt-6 block font-medium leading-6 text-gray-900 align-text-bottom">Secundaria</label>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="establecimiento_secundaria"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_secundaria' type="text"
                                            name="establecimiento_secundaria" id="establecimiento_secundaria"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_secundaria')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_secundaria"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_secundaria' type="text" name="titulo_secundaria"
                                            id="titulo_secundaria"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo_secundaria')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2 text-center">
                                    <label
                                        class="mt-6 block font-medium leading-6 text-gray-900 align-text-bottom">Diversificado</label>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="establecimiento_diversificado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_diversificado' type="text"
                                            name="establecimiento_diversificado" id="establecimiento_diversificado"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_diversificado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_diversificado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_diversificado' type="text"
                                            name="titulo_diversificado" id="titulo_diversificado"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo_diversificado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2 text-center">
                                    <label
                                        class="mt-6 block font-medium leading-6 text-gray-900 align-text-bottom">Universitario</label>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="establecimiento_universitario"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_universitario' type="text"
                                            name="establecimiento_universitario" id="establecimiento_universitario"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_universitario')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_universitario"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_universitario' type="text"
                                            name="titulo_universitario" id="titulo_universitario"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo_universitario')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2 text-center">
                                    <label
                                        class="mt-6 block font-medium leading-6 text-gray-900 align-text-bottom">Maestría
                                        o post grado</label>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="establecimiento_maestria_postgrado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_maestria_postgrado' type="text"
                                            name="establecimiento_maestria_postgrado"
                                            id="establecimiento_maestria_postgrado"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_maestria_postgrado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_maestria_postgrado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_maestria_postgrado' type="text"
                                            name="titulo_maestria_postgrado" id="titulo_maestria_postgrado"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo_maestria_postgrado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2 text-center">
                                    <label
                                        class="mt-6 block font-medium leading-6 text-gray-900 align-text-bottom">Otra
                                        especialidad</label>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="establecimiento_otra_especialidad"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_otra_especialidad' type="text"
                                            name="establecimiento_otra_especialidad"
                                            id="establecimiento_otra_especialidad"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_otra_especialidad')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_otra_especialidad"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_otra_especialidad' type="text"
                                            name="titulo_otra_especialidad" id="titulo_otra_especialidad"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('titulo_otra_especialidad')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="estudia_actualmente"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Estudia
                                        actualmente?</label>
                                    <div class="mt-2">
                                        <select wire:model='estudia_actualmente' id="estudia_actualmente"
                                            name="estudia_actualmente" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('estudia_actualmente')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="estudio_actual"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Qué estudia?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='estudio_actual' type="text" name="estudio_actual"
                                            id="estudio_actual"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('estudio_actual')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="horario_estudio_actual"
                                        class="block text-sm font-medium leading-6 text-gray-900">Horario de
                                        estudios actual
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='horario_estudio_actual' type="text"
                                            name="horario_estudio_actual" id="horario_estudio_actual"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('horario_estudio_actual')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="establecimiento_estudio_actual"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_estudio_actual' type="text"
                                            name="establecimiento_estudio_actual" id="establecimiento_estudio_actual"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('establecimiento_estudio_actual')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="etnia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Grupo étnico al
                                        que pertenece</label>
                                    <div class="mt-2">
                                        <select wire:model='etnia' id="etnia" name="etnia" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($etnias ?? [] as $etnia)
                                                <option value="{{ $etnia->id }}">
                                                    {{ $etnia->etnia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('etnia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="otro_etnia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Otro
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='otro_etnia' type="text" name="otro_etnia"
                                            id="otro_etnia"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('otro_etnia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    @foreach ($idiomas as $index => $idioma)
                                        <div class="sm:col-span-5 flex items-center">
                                            <div class="mt-2 mr-2 flex-grow">
                                                <label for="idioma_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Idioma</label>
                                                <input wire:model='idiomas.{{ $index }}.idioma'
                                                    type="text" id="idioma_{{ $index }}"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('idiomas.{{ $index }}.idioma')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mt-2 ml-2 mr-2 flex-grow">
                                                <label for="habla_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Habla
                                                    %</label>
                                                <input wire:model='idiomas.{{ $index }}.habla' type="number"
                                                    id="habla_{{ $index }}" step="1" max="100"
                                                    min="0"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('idiomas.{{ $index }}.habla')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mt-2 ml-2 mr-2 flex-grow">
                                                <label for="lectura_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Lee
                                                    %</label>
                                                <input wire:model='idiomas.{{ $index }}.lee' type="number"
                                                    id="lectura_{{ $index }}" step="1" max="100"
                                                    min="0"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('idiomas.{{ $index }}.lee')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mt-2 ml-2 flex-grow">
                                                <label for="escritura_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Escribe
                                                    %</label>
                                                <input wire:model='idiomas.{{ $index }}.escribe'
                                                    type="number" id="escritura_{{ $index }}"
                                                    step="1" max="100" min="0"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('idiomas.{{ $index }}.escribe')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            @if ($index === 0)
                                                <div class="mt-8 ml-2">
                                                    <button class="btn text-black btn-info btn-sm"
                                                        wire:click.prevent="add_lang()"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-8 ml-2">
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click.prevent="remove_lang({{ $index }})"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 12h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="sm:col-span-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">Programas de
                                        computación que domina</label>
                                </div>
                                <div class="sm:col-span-6">
                                    @foreach ($programas as $index => $programa)
                                        <div class="sm:col-span-5 flex items-center">
                                            <div class="mt-2 mr-3 flex-grow">
                                                <label for="nombre_programa_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                                    del programa</label>
                                                <input wire:model='programas.{{ $index }}.programa'
                                                    type="text" id="nombre_programa_{{ $index }}"
                                                    name="nombre_programa_{{ $index }}"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('programas.{{ $index }}.programa')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mt-2  ml-3 flex-grow">
                                                <label for="valoracion_programa_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Valoración
                                                    del programa</label>
                                                <select wire:model='programas.{{ $index }}.valoracion'
                                                    id="valoracion_programa_{{ $index }}"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                    <option value="">Seleccionar valoración</option>
                                                    <option value="1">Nada</option>
                                                    <option value="2">Regular</option>
                                                    <option value="3">Bueno</option>
                                                    <option value="4">Excelente</option>
                                                </select>
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('programas.{{ $index }}.valoracion')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            @if ($index === 0)
                                                <div class="mt-8 ml-2">
                                                    <button class="btn text-black btn-info btn-sm"
                                                        wire:click.prevent="add_program()"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-8 ml-2">
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click.prevent="remove_program({{ $index }})"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 12h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">5. Historial
                                    laboral
                                </h1>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Detalle la información de los últimos
                                tres empleos que ha tenido, iniciando por el más reciente ó actual, al más antiguo
                                de ellos.</p>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <p class="mt-3 text-sm leading-6 text-gray-600"><strong>Empleo 1</strong></p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="empresa_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.empresa' type="text"
                                            name="empresa_0" id="empresa_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.empresa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="direccion_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.direccion' type="text"
                                            name="direccion_0" id="direccion_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.direccion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.telefono' type="text"
                                            name="telefono_0" id="telefono_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jefe_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del jefe
                                        inmediato</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.jefe_inmediato' type="text"
                                            name="jefe_0" id="jefe_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.jefe_inmediato')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.cargo' type="text"
                                            name="cargo_0" id="cargo_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.cargo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="desde_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Desde</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.desde' type="date"
                                            name="desde_0" id="desde_0"
                                            max="{{ now()->subDay()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.desde')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="hasta_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hasta</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.hasta' type="date"
                                            name="hasta_0" id="hasta_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.hasta')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ultimo_sueldo_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Último
                                        sueldo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.ultimo_sueldo' type="number"
                                            name="ultimo_sueldo_0" id="ultimo_sueldo_0" step="0.01"
                                            min="0" pattern="^\d+(\.\d{1,2})?$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.ultimo_sueldo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="motivo_salida_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Motivo de
                                        salida</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.motivo_salida' type="text"
                                            name="motivo_salida_0" id="motivo_salida_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.motivo_salida')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="verificar_informacion_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Podemos
                                        verificar esta información?</label>
                                    <div class="mt-2">
                                        <select wire:model='historiales_laborales.0.verificar_informacion'
                                            id="verificar_informacion_0" name="verificar_informacion_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.verificar_informacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="razon_informacion_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Si su respuesta
                                        es NO por qué razón?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.razon_informacion' type="text"
                                            name="razon_informacion_0" id="razon_informacion_0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.0.razon_informacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <p class="mt-3 text-sm leading-6 text-gray-600"><strong>Empleo 2</strong></p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="empresa_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.empresa' type="text"
                                            name="empresa_1" id="empresa_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.empresa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="direccion_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.direccion' type="text"
                                            name="direccion_1" id="direccion_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.direccion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.telefono' type="text"
                                            name="telefono_1" id="telefono_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jefe_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del
                                        jefe
                                        inmediato</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.jefe_inmediato' type="text"
                                            name="jefe_1" id="jefe_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.jefe_inmediato')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.cargo' type="text"
                                            name="cargo_1" id="cargo_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.cargo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="desde_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Desde</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.desde' type="date"
                                            name="desde_1" id="desde_1"
                                            max="{{ now()->subDay()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.desde')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="hasta_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hasta</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.hasta' type="date"
                                            name="hasta_1" id="hasta_1" max="{{ now()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.hasta')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ultimo_sueldo_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Último
                                        sueldo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.ultimo_sueldo' type="number"
                                            name="ultimo_sueldo_1" id="ultimo_sueldo_1" step="0.01"
                                            min="0" pattern="^\d+(\.\d{1,2})?$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.ultimo_sueldo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="motivo_salida_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Motivo de
                                        salida</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.motivo_salida' type="text"
                                            name="motivo_salida_1" id="motivo_salida_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.motivo_salida')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="verificar_informacion_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Podemos
                                        verificar esta información?</label>
                                    <div class="mt-2">
                                        <select wire:model='historiales_laborales.1.verificar_informacion'
                                            id="verificar_informacion_1" name="verificar_informacion_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.verificar_informacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="razon_informacion_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Si su
                                        respuesta
                                        es NO por qué razón?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.razon_informacion' type="text"
                                            name="razon_informacion_1" id="razon_informacion_1"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.1.razon_informacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <p class="mt-3 text-sm leading-6 text-gray-600"><strong>Empleo 3</strong></p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="empresa_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.empresa' type="text"
                                            name="empresa_2" id="empresa_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.empresa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="direccion_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.direccion' type="text"
                                            name="direccion_2" id="direccion_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.direccion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.telefono' type="text"
                                            name="telefono_2" id="telefono_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jefe_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del
                                        jefe
                                        inmediato</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.jefe_inmediato' type="text"
                                            name="jefe_2" id="jefe_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.jefe_inmediato')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.cargo' type="text"
                                            name="cargo_2" id="cargo_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.cargo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="desde_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Desde</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.desde' type="date"
                                            name="desde_2" id="desde_2"
                                            max="{{ now()->subDay()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.desde')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="hasta_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hasta</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.hasta' type="date"
                                            name="hasta_2" id="hasta_2" max="{{ now()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.hasta')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ultimo_sueldo_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Último
                                        sueldo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.ultimo_sueldo' type="number"
                                            name="ultimo_sueldo_2" id="ultimo_sueldo_2" step="0.01"
                                            min="0" pattern="^\d+(\.\d{1,2})?$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.ultimo_sueldo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="motivo_salida_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Motivo de
                                        salida</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.motivo_salida' type="text"
                                            name="motivo_salida_2" id="motivo_salida_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.motivo_salida')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="verificar_informacion_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Podemos
                                        verificar esta información?</label>
                                    <div class="mt-2">
                                        <select wire:model='historiales_laborales.2.verificar_informacion'
                                            id="verificar_informacion_2" name="verificar_informacion_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.verificar_informacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="razon_informacion_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Si su
                                        respuesta
                                        es NO por qué razón?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.razon_informacion' type="text"
                                            name="razon_informacion_2" id="razon_informacion_2"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('historiales_laborales.2.razon_informacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">6. Referencias
                                </h1>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-6">
                                    <p class="mt-3 text-sm leading-6 text-gray-600"><strong>Referencias
                                            personales</strong></p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="rp_nombre_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.0.nombre' type="text"
                                            name="rp_nombre_0" id="rp_nombre_0" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.0.nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_lugar_trabajo_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lugar de
                                        trabajo</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.0.lugar_trabajo' type="text"
                                            name="rp_lugar_trabajo_0" id="rp_lugar_trabajo_0" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.0.lugar_trabajo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_telefono_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.0.telefono' type="text"
                                            name="rp_telefono_0" id="rp_telefono_0" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.0.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_nombre_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.1.nombre' type="text"
                                            name="rp_nombre_1" id="rp_nombre_1" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.1.nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_lugar_trabajo_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lugar de
                                        trabajo</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.1.lugar_trabajo' type="text"
                                            name="rp_lugar_trabajo_1" id="rp_lugar_trabajo_1" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.1.lugar_trabajo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_telefono_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.1.telefono' type="text"
                                            name="rp_telefono_1" id="rp_telefono_1" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.1.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_nombre_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.2.nombre' type="text"
                                            name="rp_nombre_2" id="rp_nombre_2" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.2.nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_lugar_trabajo_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lugar de
                                        trabajo</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.2.lugar_trabajo' type="text"
                                            name="rp_lugar_trabajo_2" id="rp_lugar_trabajo_2" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.2.lugar_trabajo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_telefono_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.2.telefono' type="text"
                                            name="rp_telefono_2" id="rp_telefono_2" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_personales.2.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <p class="mt-3 text-sm leading-6 text-gray-600"><strong>Referencias
                                            laborales</strong></p>
                                    <hr>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="rl_nombre_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.0.nombre' type="text"
                                            name="rl_nombre_0" id="rl_nombre_0" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.0.nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_empresa_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.0.empresa' type="text"
                                            name="rl_empresa_0" id="rl_empresa_0" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.0.empresa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_telefono_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.0.telefono' type="text"
                                            name="rl_telefono_0" id="rl_telefono_0" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.0.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_nombre_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.1.nombre' type="text"
                                            name="rl_nombre_1" id="rl_nombre_1" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.1.nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_empresa_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.1.empresa' type="text"
                                            name="rl_empresa_1" id="rl_empresa_1" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.1.empresa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_telefono_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.1.telefono' type="text"
                                            name="rl_telefono_1" id="rl_telefono_1" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.1.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_nombre_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.2.nombre' type="text"
                                            name="rl_nombre_2" id="rl_nombre_2" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.2.nombre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_empresa_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.2.empresa' type="text"
                                            name="rl_empresa_2" id="rl_empresa_2" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.2.empresa')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_telefono_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.2.telefono' type="text"
                                            name="rl_telefono_2" id="rl_telefono_2" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('referencias_laborales.2.telefono')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">7. Aspectos
                                    socioeconómicos
                                </h1>
                            </div>
                            </h2>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-3">
                                    <label for="tipo_vivienda"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        vivienda</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_vivienda' id="tipo_vivienda" name="tipo_vivienda"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_viviendas ?? [] as $tipo_vivienda)
                                                <option value="{{ $tipo_vivienda->id }}">
                                                    {{ $tipo_vivienda->tipo_vivienda }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_vivienda')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="pago_vivienda"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cuánto paga
                                        mensualmente por concepto de vivienda?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='pago_vivienda' type="number" name="pago_vivienda"
                                            id="pago_vivienda" required step="0.01" min="0"
                                            pattern="^\d+(\.\d{1,2})?$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('pago_vivienda')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="cantidad_personas_dependientes"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cuántas
                                        personas dependen económicamente de usted?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='cantidad_personas_dependientes' type="number"
                                            name="cantidad_personas_dependientes"
                                            id="cantidad_personas_dependientes" required step="1"
                                            min="0"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('cantidad_personas_dependientes')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    @foreach ($personas_dependientes as $index => $persona_dependiente)
                                        <div class="sm:col-span-5 flex items-center">
                                            <div class="mt-2 mr-3 flex-grow" style="width: 516px;">
                                                <label for="nombre_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                                <input wire:model='personas_dependientes.{{ $index }}.nombre'
                                                    type="text" id="nombre_{{ $index }}"
                                                    name="nombre_{{ $index }}"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('personas_dependientes.{{ $index }}.nombre')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mt-2 ml-3 mr-2 flex-grow">
                                                <label for="parentesco_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Parentesco</label>
                                                <input
                                                    wire:model='personas_dependientes.{{ $index }}.parentesco'
                                                    type="text" id="parentesco_{{ $index }}"
                                                    name="parentesco_{{ $index }}"
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div>
                                                <span class="text-red-600 text-sm">
                                                    @error('personas_dependientes.{{ $index }}.parentesco')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            @if ($index === 0)
                                                <div class="mt-8 ml-2">
                                                    <button class="btn text-black btn-info btn-sm"
                                                        wire:click.prevent="add_persona_dependiente()"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-8 ml-2">
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:click.prevent="remove_persona_dependiente({{ $index }})"><svg
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 12h-15" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="ingresos_adicionales"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Recibe ingresos
                                        adicionales a su salario?</label>
                                    <div class="mt-2">
                                        <select wire:model='ingresos_adicionales' id="ingresos_adicionales"
                                            name="ingresos_adicionales" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('ingresos_adicionales')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="fuente_ingresos_adicionales"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso
                                        afirmativo ¿De dónde proviene su ingreso?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='fuente_ingresos_adicionales' type="text"
                                            name="fuente_ingresos_adicionales" id="fuente_ingresos_adicionales"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fuente_ingresos_adicionales')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="personas_aportan_ingresos"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Quiénes aportan
                                        ingreso a su hogar?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='personas_aportan_ingresos' type="text"
                                            name="personas_aportan_ingresos" id="personas_aportan_ingresos"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('personas_aportan_ingresos')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="monto_ingreso_total"
                                        class="block text-sm font-medium leading-6 text-gray-900">Monto aproximado
                                        de ingreso total
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='monto_ingreso_total' type="number"
                                            name="monto_ingreso_total" id="monto_ingreso_total" step="0.01"
                                            min="0" pattern="^\d+(\.\d{1,2})?$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('monto_ingreso_total')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="posee_deudas"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Tiene
                                        deudas?</label>
                                    <div class="mt-2">
                                        <select wire:model='posee_deudas' id="posee_deudas" name="posee_deudas"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('posee_deudas')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_deuda"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso
                                        afirmativo, indique el tipo de deudas que tiene:
                                    </label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_deuda' id="tipo_deuda" name="tipo_deuda"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_deudas ?? [] as $tipo_deuda)
                                                <option value="{{ $tipo_deuda->id }}">
                                                    {{ $tipo_deuda->tipo_deuda }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_deuda')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="monto_deuda"
                                        class="block text-sm font-medium leading-6 text-gray-900">Monto</label>
                                    <div class="mt-2">
                                        <input wire:model='monto_deuda' type="number" name="monto_deuda"
                                            id="monto_deuda" step="0.01" min="0"
                                            pattern="^\d+(\.\d{1,2})?$"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('monto_deuda')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">8. Otros datos
                                </h1>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-3">
                                    <label for="trabajo_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Ha laborado
                                        anteriormente para esta institución?</label>
                                    <div class="mt-2">
                                        <select wire:model='trabajo_conred' id="trabajo_conred"
                                            name="trabajo_conred" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('trabajo_conred')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="trabajo_estado"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Ha laborado con
                                        anterioridad en instituciones del Estado?</label>
                                    <div class="mt-2">
                                        <select wire:model='trabajo_estado' id="trabajo_estado"
                                            name="trabajo_estado" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('trabajo_estado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jubilado_estado"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Es usted
                                        jubilado del Estado?</label>
                                    <div class="mt-2">
                                        <select wire:model='jubilado_estado' id="jubilado_estado"
                                            name="jubilado_estado" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('jubilado_estado')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="institucion_jubilacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso
                                        afirmativo, ¿de qué institución?</label>
                                    <div class="mt-2">
                                        <input wire:model='institucion_jubilacion' type="text"
                                            name="institucion_jubilacion" id="institucion_jubilacion"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('institucion_jubilacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="rounded-lg bg-primary-100 text-xl">
                                <h1 class="p-2 mt-8 font-semibold leading-7 text-gray-900">9. Historia clínica
                                </h1>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-3">
                                    <label for="padecimiento_salud"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Sufre algún
                                        padecimiento de salud?</label>
                                    <div class="mt-2">
                                        <select wire:model='padecimiento_salud' id="padecimiento_salud"
                                            name="padecimiento_salud" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('padecimiento_salud')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_enfermedad"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Qué tipo de
                                        enfermedad padece?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_enfermedad' type="text" name="tipo_enfermedad"
                                            id="tipo_enfermedad"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_enfermedad')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="intervencion_quirurgica"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Se ha sometido
                                        a algún tipo de intervención quirúrgirca?</label>
                                    <div class="mt-2">
                                        <select wire:model='intervencion_quirurgica' id="intervencion_quirurgica"
                                            name="intervencion_quirurgica" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('intervencion_quirurgica')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_intervencion"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cuál?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_intervencion' type="text"
                                            name="tipo_intervencion" id="tipo_intervencion"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_intervencion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="sufrido_accidente"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Ha sufrido
                                        algún accidente?</label>
                                    <div class="mt-2">
                                        <select wire:model='sufrido_accidente' id="sufrido_accidente"
                                            name="sufrido_accidente" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('sufrido_accidente')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_accidente"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cúal?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_accidente' type="text" name="tipo_accidente"
                                            id="tipo_accidente"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_accidente')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="alergia_medicamento"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Es alérgico a
                                        algún tipo de medicamento?</label>
                                    <div class="mt-2">
                                        <select wire:model='alergia_medicamento' id="alergia_medicamento"
                                            name="alergia_medicamento" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($si_no ?? [] as $sn)
                                                <option value="{{ $sn['val'] }}">
                                                    {{ $sn['res'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('alergia_medicamento')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_medicamento"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cúal?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_medicamento' type="text"
                                            name="tipo_medicamento" id="tipo_medicamento"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_medicamento')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="tipo_sangre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        sangre</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_sangre' id="tipo_sangre" name="tipo_sangre"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($grupos_sanguineos ?? [] as $gs)
                                                <option value="{{ $gs->id }}">
                                                    {{ $gs->grupo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('tipo_sangre')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="nombre_contacto_emergencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso de
                                        emergencia notificar a</label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_contacto_emergencia' type="text"
                                            name="nombre_contacto_emergencia" id="nombre_contacto_emergencia"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nombre_contacto_emergencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_contacto_emergencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_contacto_emergencia' type="text"
                                            name="telefono_contacto_emergencia" id="telefono_contacto_emergencia"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('telefono_contacto_emergencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="direccion_contacto_emergencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección para
                                        notificarle</label>
                                    <div class="mt-2">
                                        <input wire:model='direccion_contacto_emergencia' type="text"
                                            name="direccion_contacto_emergencia" id="direccion_contacto_emergencia"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('direccion_contacto_emergencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" wire:click='cerrarModal()'
                        class="inline-block rounded-lg bg-danger-200 px-6 pb-2 pt-2.5 font-medium leading-normal text-danger-700 transition duration-150 ease-in-out hover:bg-red-400 focus:bg-red-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                        data-te-ripple-init data-te-ripple-color="light">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                        data-te-ripple-init data-te-ripple-color="light">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
