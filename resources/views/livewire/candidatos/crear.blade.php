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
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-800"
                    id="exampleModalCenterTitle">
                    @if ($modo_edicion)
                        Editar registro
                    @else
                        Nuevo registro
                    @endif
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
            <div class="relative p-4">
                <form id="candidatoForm" method="POST" wire:submit='guardar'>
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Información personal</h2>
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
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-2">
                                    <label for="dpi"
                                        class="block text-sm font-medium leading-6 text-gray-900">DPI</label>
                                    <div class="mt-2">
                                        <input wire:model='dpi' type="text" name="dpi" id="dpi" required
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
                                    <label for="nit"
                                        class="block text-sm font-medium leading-6 text-gray-900">NIT</label>
                                    <div class="mt-2">
                                        <input wire:model='nit' type="text" name="nit" id="nit" required
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
                                    <label for="igss"
                                        class="block text-sm font-medium leading-6 text-gray-900">IGSS</label>
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

                                <div class="sm:col-span-3">
                                    <label for="nombre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                        completo</label>
                                    <div class="mt-2">
                                        <input wire:model='nombre' type="text" name="nombre" id="nombre"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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

                                <div class="sm:col-span-2">
                                    <label for="fecha_nacimiento"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        nacimiento</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_nacimiento' type="date"
                                            max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                            name="fecha_de_nacimiento" id="fecha_nacimiento" required
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

                                <div class="sm:col-span-2">
                                    <label for="estado_civil"
                                        class="block text-sm font-medium leading-6 text-gray-900">Estado civil</label>
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

                                <div class="sm:col-span-2">
                                    <label for="fecha_registro"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        registro</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_registro' type="date" name="fecha_de_registro"
                                            id="fecha_registro" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="direccion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='direccion' type="text" name="dirección" id="direccion"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('direccion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='telefono' type="text" name="teléfono" id="telefono"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="departamento"
                                        class="block text-sm font-medium leading-6 text-gray-900">Departamento</label>
                                    <div class="mt-2">
                                        <select wire:model='departamento' wire:change='getMunicipiosByDepartamento'
                                            id="departamento" name="departamento" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos ?? [] as $departamento)
                                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
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
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Información académica</h2>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">

                                <div class="sm:col-span-1">
                                    <label for="registro_academico"
                                        class="block text-sm font-medium leading-6 text-gray-900">Registro
                                        académico</label>
                                    <div class="mt-2">
                                        <select wire:model='registro_academico' id="registro_academico"
                                            name="registro_académico" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($registros_academicos ?? [] as $registro_academico)
                                                <option value="{{ $registro_academico->id }}">
                                                    {{ $registro_academico->nivel }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    <label for="titulo"
                                        class="block text-sm font-medium leading-6 text-gray-900">Profesión
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo' type="text" name="título" id="titulo"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                    <label for="registro_academico_estado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Estado</label>
                                    <div class="mt-2">
                                        <select wire:model='registro_academico_estado' id="registro_academico_estado"
                                            name="registro_académico" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            <option value="1">En curso</option>
                                            <option value="2">Finalizado</option>
                                            {{-- @foreach ($registros_academicos ?? [] as $registro_academico_estado)
                                                <option value="{{ $registro_academico_estado->id }}">
                                                    {{ $registro_academico_estado->titulo }}
                                                </option>
                                            @endforeach --}}
                                        </select>
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
                                    <label for="colegio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Colegio</label>
                                    <div class="mt-2">
                                        <select wire:model='colegio' id="colegio" name="colegio"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($colegios ?? [] as $colegio)
                                                <option value="{{ $colegio->id }}">
                                                    {{ $colegio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    <label for="colegiado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Colegiado
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='colegiado' type="number" name="colegiado" id="colegiado"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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

                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Información laboral</h2>
                            <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">

                                <div class="sm:col-span-2">
                                    <label for="tipo_contratacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        contratación</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_contratacion' id="tipo_contratacion"
                                            name="tipo_contratación" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_contrataciones ?? [] as $contratacion)
                                                <option value="{{ $contratacion->id }}">
                                                    {{ $contratacion->tipo }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    <label for="tipo_servicio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        servicio</label>
                                    <div class="mt-2">
                                        <select wire:model='tipo_servicio' wire:change='getPuestosByTipoServicio'
                                            id="tipo_servicio" name="tipo_servicio" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_servicios ?? [] as $servicio)
                                                <option value="{{ $servicio->id }}">
                                                    {{ $servicio->tipo_servicio }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    <label for="fecha_aplicacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        aplicación</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_aplicacion' type="date"
                                            name="fecha_de_aplicación" id="fecha_aplicacion" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_aplicacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="dependencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dependencia</label>
                                    <div class="mt-2">
                                        <select wire:model='dependencia' wire:change='getPuestosByDependencia'
                                            id="dependencia" name="dependencia" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias ?? [] as $dependencia)
                                                <option value="{{ $dependencia->id }}">
                                                    {{ $dependencia->dependencia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('dependencia')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="puesto"
                                        class="block text-sm font-medium leading-6 text-gray-900">Puesto</label>
                                    <div class="mt-2">
                                        <select wire:model='puesto' id="puesto" name="puesto" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($puestos ?? [] as $psto)
                                                <option value="{{ $psto->id }}">
                                                    {{ $psto->codigo }} - {{ $psto->puesto }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    <label for="observacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Observación</label>
                                    <div class="mt-2">
                                        <textarea wire:model='observacion' id="observacion" name="observación" rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Breve descripción para la
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
                        {{-- <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button type="button"
                                class="text-sm font-semibold leading-6 text-gray-900">{{ __('Cancel') }}</button>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Save') }}</button>
                        </div> --}}
                </form>
            </div>
            <div wire:loading.flex wire:target="guardar"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
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
                <button type="submit" form="candidatoForm"
                    class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </div>
</div>
