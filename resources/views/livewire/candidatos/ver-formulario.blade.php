<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Formulario de solicitud de contratación') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-2">
                <div class="sm:col-span-6">
                </div>
            </div>
            @if ($modal)
                @include('livewire.formularios.rechazar-formulario')
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 mb-6">
                                <div class="sm:col-span-6 mx-auto">
                                    <img src="{{ asset('storage') . '/' . $imagen }}"
                                        class="mx-auto max-w-full rounded-lg" style="height: 150px" alt="imagen" />
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
                                            readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="apellidos"
                                        class="block text-sm font-medium leading-6 text-gray-900">Apellidos</label>
                                    <div class="mt-2">
                                        <input wire:model='apellidos' type="text" name="apellidos" id="apellidos"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="puesto"
                                        class="block text-sm font-medium leading-6 text-gray-900">Puesto</label>
                                    <div class="mt-2">
                                        <input wire:model='puesto' type="text" name="puesto" id="puesto" readonly
                                            disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="pretension_salarial"
                                        class="block text-sm font-medium leading-6 text-gray-900">Pretensión
                                        salarial</label>
                                    <div class="mt-2">
                                        <input wire:model='pretension_salarial' type="text"
                                            name="pretension_salarial" id="pretension_salarial" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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

                                <div class="sm:col-span-2">
                                    <label for="departamento"
                                        class="block text-sm font-medium leading-6 text-gray-900">Departamento</label>
                                    <div class="mt-2">
                                        <input wire:model='departamento' type="text" name="departamento"
                                            id="departamento" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="municipio"
                                        class="block text-sm font-medium leading-6 text-gray-900">Municipio</label>
                                    <div class="mt-2">
                                        <input wire:model='municipio' type="text" name="municipio" id="municipio"
                                            readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="fecha_nacimiento"
                                        class="block text-sm font-medium leading-6 text-gray-900">Fecha de
                                        nacimiento</label>
                                    <div class="mt-2">
                                        <input wire:model='fecha_nacimiento' type="date" name="fecha_nacimiento"
                                            id="fecha_nacimiento" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="nacionalidad"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nacionalidad</label>
                                    <div class="mt-2">
                                        <input wire:model='nacionalidad' type="text" name="nacionalidad"
                                            id="nacionalidad" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="estado_civil"
                                        class="block text-sm font-medium leading-6 text-gray-900">Estado
                                        civil</label>
                                    <div class="mt-2">
                                        <input wire:model='estado_civil' type="text" name="estado_civil"
                                            id="estado_civil" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="direccion"
                                        class="block text-sm font-medium leading-6 text-gray-900">Residencia
                                        actual</label>
                                    <div class="mt-2">
                                        <input wire:model='direccion' type="text" name="direccion" id="direccion"
                                            disabled readonly
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
                                    <label for="dpi"
                                        class="block text-sm font-medium leading-6 text-gray-900">DPI</label>
                                    <div class="mt-2">
                                        <input wire:model='dpi' type="text" name="dpi" id="dpi"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="departamento_emision"
                                        class="block text-sm font-medium leading-6 text-gray-900">Departamento de
                                        emisión</label>
                                    <div class="mt-2">
                                        <input wire:model='departamento_emision' type="text"
                                            name="departamento_emision" id="departamento_emision" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="municipio_emision"
                                        class="block text-sm font-medium leading-6 text-gray-900">Municipio de
                                        emision</label>
                                    <div class="mt-2">
                                        <input wire:model='municipio_emision' type="text" name="municipio_emision"
                                            id="municipio_emision" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="igss"
                                        class="block text-sm font-medium leading-6 text-gray-900">Número de afiliación
                                        IGSS</label>
                                    <div class="mt-2">
                                        <input wire:model='igss' type="text" name="igss" id="igss"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="nit"
                                        class="block text-sm font-medium leading-6 text-gray-900">NIT</label>
                                    <div class="mt-2">
                                        <input wire:model='nit' type="text" name="nit" id="nit"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="licencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Número de
                                        licencia</label>
                                    <div class="mt-2">
                                        <input wire:model='licencia' type="text" name="licencia" id="licencia"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="tipo_licencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        licencia</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_licencia' type="text" name="tipo_licencia"
                                            id="tipo_licencia" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="tipo_vehiculo"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        vehículo</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_vehiculo' type="text" name="tipo_vehiculo"
                                            id="tipo_vehiculo" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="placa"
                                        class="block text-sm font-medium leading-6 text-gray-900">Placa
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='placa' type="text" name="placa" id="placa"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_casa"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono de casa
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_casa' type="text" name="telefono_casa"
                                            id="telefono_casa" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_movil"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono móvil
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_movil' type="text" name="telefono_movil"
                                            id="telefono_movil" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Correo
                                        electrónico</label>
                                    <div class="mt-2">
                                        <input wire:model='email' type="email" name="email" id="email"
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                        <input wire:model='familiar_conred' type="text" name="familiar_conred"
                                            id="familiar_conred" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_familiar_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_familiar_conred' type="text"
                                            name="nombre_familiar_conred" id="nombre_familiar_conred" disabled
                                            readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_familiar_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='cargo_familiar_conred' type="text"
                                            name="cargo_familiar_conred" id="cargo_familiar_conred" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="conocido_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Conoce a alguien
                                        que labora en la institución?</label>
                                    <div class="mt-2">
                                        <input wire:model='conocido_conred' type="text" name="conocido_conred"
                                            id="conocido_conred" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_conocido_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_conocido_conred' type="text"
                                            name="nombre_conocido_conred" id="nombre_conocido_conred" disabled
                                            readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_conocido_conred"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='cargo_conocido_conred' type="text"
                                            name="cargo_conocido_conred" id="cargo_conocido_conred" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_padre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono del
                                        padre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_padre' type="text" name="telefono_padre"
                                            id="telefono_padre" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_padre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del padre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_padre' type="text" name="nombre_padre"
                                            id="nombre_padre" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ocupacion_padre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ocupación del
                                        padre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='ocupacion_padre' type="text" name="ocupacion_padre"
                                            id="ocupacion_padre" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_madre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono de la
                                        madre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_madre' type="text" name="telefono_madre"
                                            id="telefono_madre" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_madre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre de la
                                        madre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_madre' type="text" name="nombre_madre"
                                            id="nombre_madre" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ocupacion_madre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ocupación de la
                                        madre
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='ocupacion_madre' type="text" name="ocupacion_madre"
                                            id="ocupacion_madre" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="telefono_conviviente"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono del
                                        esposo(a) o conviviente
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_conviviente' type="text"
                                            name="telefono_conviviente" id="telefono_conviviente" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="nombre_conviviente"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del
                                        esposo(a) o conviviente
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_conviviente' type="text"
                                            name="nombre_conviviente" id="nombre_conviviente" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ocupacion_conviviente"
                                        class="block text-sm font-medium leading-6 text-gray-900">Ocupación del
                                        esposo(a) o conviviente
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='ocupacion_conviviente' type="text"
                                            name="ocupacion_conviviente" id="ocupacion_conviviente" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">Nombres y
                                        apellidos de sus hijos</label>
                                    @foreach ($hijos as $index => $hijo)
                                        <div class="sm:col-span-5 flex items-center">
                                            <div class="mt-2 flex-grow">
                                                <input wire:model='hijos.{{ $index }}.nombre' type="text"
                                                    id="hijo_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
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
                                            name="establecimiento_primaria" id="establecimiento_primaria" disabled
                                            readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_primaria"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_primaria' type="text" name="titulo_primaria"
                                            id="titulo_primaria" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="establecimiento_secundaria" id="establecimiento_secundaria" disabled
                                            readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_secundaria"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_secundaria' type="text" name="titulo_secundaria"
                                            id="titulo_secundaria" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_diversificado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_diversificado' type="text"
                                            name="titulo_diversificado" id="titulo_diversificado" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_universitario"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_universitario' type="text"
                                            name="titulo_universitario" id="titulo_universitario" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            id="establecimiento_maestria_postgrado" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_maestria_postgrado"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_maestria_postgrado' type="text" disabled readonly
                                            name="titulo_maestria_postgrado" id="titulo_maestria_postgrado"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            id="establecimiento_otra_especialidad" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="titulo_otra_especialidad"
                                        class="block text-sm font-medium leading-6 text-gray-900">Título obtenido
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='titulo_otra_especialidad' type="text" disabled readonly
                                            name="titulo_otra_especialidad" id="titulo_otra_especialidad"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="estudia_actualmente"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Estudia
                                        actualmente?</label>
                                    <div class="mt-2">
                                        <input wire:model='estudia_actualmente' type="text"
                                            name="estudia_actualmente" id="estudia_actualmente" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="estudio_actual"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Qué estudia?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='estudio_actual' type="text" name="estudio_actual"
                                            id="estudio_actual" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="horario_estudio_actual"
                                        class="block text-sm font-medium leading-6 text-gray-900">Horario de
                                        estudios actual
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='horario_estudio_actual' type="text"
                                            name="horario_estudio_actual" id="horario_estudio_actual" disabled
                                            readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="establecimiento_estudio_actual"
                                        class="block text-sm font-medium leading-6 text-gray-900">Establecimiento
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='establecimiento_estudio_actual' type="text" disabled
                                            readonly name="establecimiento_estudio_actual"
                                            id="establecimiento_estudio_actual"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="etnia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Grupo étnico al
                                        que pertenece</label>
                                    <div class="mt-2">
                                        <input wire:model='etnia' type="text" name="etnia" id="etnia"
                                            readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="otro_etnia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Otro
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='otro_etnia' type="text" name="otro_etnia"
                                            id="otro_etnia" readonly disabled
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    @foreach ($idiomas as $index => $idioma)
                                        <div class="sm:col-span-5 flex items-center">
                                            <div class="mt-2 mr-2 flex-grow">
                                                <label for="idioma_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Idioma</label>
                                                <input wire:model='idiomas.{{ $index }}.idioma' type="text"
                                                    id="idioma_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div class="mt-2 ml-2 mr-2 flex-grow">
                                                <label for="habla_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Habla
                                                    %</label>
                                                <input wire:model='idiomas.{{ $index }}.habla' type="text"
                                                    id="habla_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div class="mt-2 ml-2 mr-2 flex-grow">
                                                <label for="lectura_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Lee
                                                    %</label>
                                                <input wire:model='idiomas.{{ $index }}.lee'
                                                    type="text" id="lectura_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div class="mt-2 ml-2 flex-grow">
                                                <label for="escritura_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Escribe
                                                    %</label>
                                                <input wire:model='idiomas.{{ $index }}.escribe'
                                                    type="number" id="escritura_{{ $index }}" disabled
                                                    readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
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
                                                    name="nombre_programa_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div class="ml-3 flex-grow">
                                                <label for="valoracion_programa_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Valoración
                                                    del programa</label>
                                                <div class="mt-2">
                                                    <input wire:model='programas.{{ $index }}.valoracion'
                                                        type="text" name="valoracion_programa_{{ $index }}"
                                                        id="valoracion_programa_{{ $index }}" readonly disabled
                                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                </div>
                                            </div>
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
                                            name="empresa_0" id="empresa_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="direccion_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.direccion' type="text"
                                            name="direccion_0" id="direccion_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.telefono' type="text"
                                            name="telefono_0" id="telefono_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jefe_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del jefe
                                        inmediato</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.jefe_inmediato' type="text"
                                            name="jefe_0" id="jefe_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.cargo' type="text"
                                            name="cargo_0" id="cargo_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="desde_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Desde</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.desde' type="date"
                                            name="desde_0" id="desde_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="hasta_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hasta</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.hasta' type="date"
                                            name="hasta_0" id="hasta_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ultimo_sueldo_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Último
                                        sueldo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.ultimo_sueldo' type="text"
                                            name="ultimo_sueldo_0" id="ultimo_sueldo_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="motivo_salida_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Motivo de
                                        salida</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.motivo_salida' type="text"
                                            name="motivo_salida_0" id="motivo_salida_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="verificar_informacion_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Podemos
                                        verificar esta información?</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.verificar_informacion'
                                            type="text" name="verificar_informacion_0"
                                            id="verificar_informacion_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="razon_informacion_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Si su respuesta
                                        es NO por qué razón?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.0.razon_informacion' type="text"
                                            name="razon_informacion_0" id="razon_informacion_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="empresa_1" id="empresa_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="direccion_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.direccion' type="text"
                                            name="direccion_1" id="direccion_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.telefono' type="text"
                                            name="telefono_1" id="telefono_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jefe_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del
                                        jefe
                                        inmediato</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.jefe_inmediato' type="text"
                                            name="jefe_1" id="jefe_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.cargo' type="text"
                                            name="cargo_1" id="cargo_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="desde_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Desde</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.desde' type="date"
                                            name="desde_1" id="desde_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="hasta_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hasta</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.hasta' type="date"
                                            name="hasta_1" id="hasta_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ultimo_sueldo_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Último
                                        sueldo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.ultimo_sueldo' type="text"
                                            name="ultimo_sueldo_1" id="ultimo_sueldo_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="motivo_salida_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Motivo de
                                        salida</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.motivo_salida' type="text"
                                            name="motivo_salida_1" id="motivo_salida_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="verificar_informacion_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Podemos
                                        verificar esta información?</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.1.verificar_informacion'
                                            type="text" name="verificar_informacion_1"
                                            id="verificar_informacion_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="razon_informacion_1" id="razon_informacion_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="empresa_2" id="empresa_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="direccion_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.direccion' type="text"
                                            name="direccion_2" id="direccion_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.telefono' type="text"
                                            name="telefono_2" id="telefono_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jefe_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre del
                                        jefe
                                        inmediato</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.jefe_inmediato' type="text"
                                            name="jefe_2" id="jefe_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="cargo_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Cargo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.cargo' type="text"
                                            name="cargo_2" id="cargo_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="desde_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Desde</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.desde' type="date"
                                            name="desde_2" id="desde_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="hasta_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Hasta</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.hasta' type="date"
                                            name="hasta_2" id="hasta_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="ultimo_sueldo_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Último
                                        sueldo</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.ultimo_sueldo' type="text"
                                            name="ultimo_sueldo_2" id="ultimo_sueldo_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="motivo_salida_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Motivo de
                                        salida</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.motivo_salida' type="text"
                                            name="motivo_salida_2" id="motivo_salida_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="verificar_informacion_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Podemos
                                        verificar esta información?</label>
                                    <div class="mt-2">
                                        <input wire:model='historiales_laborales.2.verificar_informacion'
                                            type="text" name="verificar_informacion_2"
                                            id="verificar_informacion_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="razon_informacion_2" id="razon_informacion_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="rp_nombre_0" id="rp_nombre_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_lugar_trabajo_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lugar de
                                        trabajo</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.0.lugar_trabajo' type="text"
                                            name="rp_lugar_trabajo_0" id="rp_lugar_trabajo_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_telefono_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.0.telefono' type="text"
                                            name="rp_telefono_0" id="rp_telefono_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_nombre_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.1.nombre' type="text"
                                            name="rp_nombre_1" id="rp_nombre_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_lugar_trabajo_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lugar de
                                        trabajo</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.1.lugar_trabajo' type="text"
                                            name="rp_lugar_trabajo_1" id="rp_lugar_trabajo_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_telefono_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.1.telefono' type="text"
                                            name="rp_telefono_1" id="rp_telefono_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_nombre_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.2.nombre' type="text"
                                            name="rp_nombre_2" id="rp_nombre_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_lugar_trabajo_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Lugar de
                                        trabajo</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.2.lugar_trabajo' type="text"
                                            name="rp_lugar_trabajo_2" id="rp_lugar_trabajo_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rp_telefono_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_personales.2.telefono' type="text"
                                            name="rp_telefono_2" id="rp_telefono_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                            name="rl_nombre_0" id="rl_nombre_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_empresa_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.0.empresa' type="text"
                                            name="rl_empresa_0" id="rl_empresa_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_telefono_0"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.0.telefono' type="text"
                                            name="rl_telefono_0" id="rl_telefono_0" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_nombre_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.1.nombre' type="text"
                                            name="rl_nombre_1" id="rl_nombre_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_empresa_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.1.empresa' type="text"
                                            name="rl_empresa_1" id="rl_empresa_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_telefono_1"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.1.telefono' type="text"
                                            name="rl_telefono_1" id="rl_telefono_1" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_nombre_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.2.nombre' type="text"
                                            name="rl_nombre_2" id="rl_nombre_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_empresa_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Empresa</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.2.empresa' type="text"
                                            name="rl_empresa_2" id="rl_empresa_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="rl_telefono_2"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='referencias_laborales.2.telefono' type="text"
                                            name="rl_telefono_2" id="rl_telefono_2" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                        <input wire:model='tipo_vivienda' type="text" name="tipo_vivienda"
                                            id="tipo_vivienda" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="pago_vivienda"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cuánto paga
                                        mensualmente por concepto de vivienda?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='pago_vivienda' type="text" name="pago_vivienda"
                                            id="pago_vivienda" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="cantidad_personas_dependientes"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cuántas
                                        personas dependen económicamente de usted?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='cantidad_personas_dependientes' type="text"
                                            name="cantidad_personas_dependientes"
                                            id="cantidad_personas_dependientes" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                                    name="nombre_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                            <div class="mt-2 ml-3 mr-2 flex-grow">
                                                <label for="parentesco_{{ $index }}"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Parentesco</label>
                                                <input
                                                    wire:model='personas_dependientes.{{ $index }}.parentesco'
                                                    type="text" id="parentesco_{{ $index }}"
                                                    name="parentesco_{{ $index }}" disabled readonly
                                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="ingresos_adicionales"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Recibe ingresos
                                        adicionales a su salario?</label>
                                    <div class="mt-2">
                                        <input wire:model='ingresos_adicionales' type="text"
                                            name="ingresos_adicionales" id="ingresos_adicionales" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="fuente_ingresos_adicionales"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso
                                        afirmativo ¿De dónde proviene su ingreso?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='fuente_ingresos_adicionales' type="text" disabled
                                            readonly name="fuente_ingresos_adicionales"
                                            id="fuente_ingresos_adicionales"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="personas_aportan_ingresos"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Quiénes aportan
                                        ingreso a su hogar?
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='personas_aportan_ingresos' type="text" disabled
                                            readonly name="personas_aportan_ingresos" id="personas_aportan_ingresos"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="monto_ingreso_total"
                                        class="block text-sm font-medium leading-6 text-gray-900">Monto aproximado
                                        de ingreso total
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='monto_ingreso_total' type="number"
                                            name="monto_ingreso_total" id="monto_ingreso_total" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="posee_deudas"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Tiene
                                        deudas?</label>
                                    <div class="mt-2">
                                        <input wire:model='posee_deudas' type="text" name="posee_deudas"
                                            id="posee_deudas" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_deuda"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso
                                        afirmativo, indique el tipo de deudas que tiene:
                                    </label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_deuda' type="text" name="tipo_deuda"
                                            id="tipo_deuda" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="monto_deuda"
                                        class="block text-sm font-medium leading-6 text-gray-900">Monto</label>
                                    <div class="mt-2">
                                        <input wire:model='monto_deuda' type="text" name="monto_deuda"
                                            id="monto_deuda" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                        <input wire:model='trabajo_conred' type="text" name="trabajo_conred"
                                            id="trabajo_conred" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                        <input wire:model='trabajo_estado' type="text" name="trabajo_estado"
                                            id="trabajo_estado" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="jubilado_estado"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Es usted
                                        jubilado del Estado?</label>
                                    <div class="mt-2">
                                        <input wire:model='jubilado_estado' type="text" name="jubilado_estado"
                                            id="jubilado_estado" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="institucion_jubilacion"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso
                                        afirmativo, ¿de qué institución?</label>
                                    <div class="mt-2">
                                        <input wire:model='institucion_jubilacion' type="text" disabled readonly
                                            name="institucion_jubilacion" id="institucion_jubilacion"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
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
                                        <input wire:model='padecimiento_salud' type="text"
                                            name="padecimiento_salud" id="padecimiento_salud" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_enfermedad"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Qué tipo de
                                        enfermedad padece?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_enfermedad' type="text" name="tipo_enfermedad"
                                            id="tipo_enfermedad" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="intervencion_quirurgica"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Se ha sometido
                                        a algún tipo de intervención quirúrgirca?</label>
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <input wire:model='intervencion_quirurgica' type="text"
                                                name="intervencion_quirurgica" id="intervencion_quirurgica" disabled
                                                readonly
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_intervencion"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cuál?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_intervencion' type="text" disabled readonly
                                            name="tipo_intervencion" id="tipo_intervencion"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="sufrido_accidente"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Ha sufrido
                                        algún accidente?</label>
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <input wire:model='sufrido_accidente' type="text"
                                                name="sufrido_accidente" id="sufrido_accidente" disabled readonly
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_accidente"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cúal?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_accidente' type="text" name="tipo_accidente"
                                            id="tipo_accidente" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="alergia_medicamento"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Es alérgico a
                                        algún tipo de medicamento?</label>
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <input wire:model='alergia_medicamento' type="text"
                                                name="alergia_medicamento" id="alergia_medicamento" disabled
                                                readonly
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tipo_medicamento"
                                        class="block text-sm font-medium leading-6 text-gray-900">¿Cúal?</label>
                                    <div class="mt-2">
                                        <input wire:model='tipo_medicamento' type="text"
                                            name="tipo_medicamento" id="tipo_medicamento" disabled readonly
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="tipo_sangre"
                                        class="block text-sm font-medium leading-6 text-gray-900">Tipo de
                                        sangre</label>
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <input wire:model='tipo_sangre' type="text" name="tipo_sangre"
                                                id="tipo_sangre" disabled readonly
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="nombre_contacto_emergencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">En caso de
                                        emergencia notificar a</label>
                                    <div class="mt-2">
                                        <input wire:model='nombre_contacto_emergencia' type="text" disabled
                                            readonly name="nombre_contacto_emergencia"
                                            id="nombre_contacto_emergencia"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="telefono_contacto_emergencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Teléfono</label>
                                    <div class="mt-2">
                                        <input wire:model='telefono_contacto_emergencia' type="text" disabled
                                            readonly name="telefono_contacto_emergencia"
                                            id="telefono_contacto_emergencia"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="direccion_contacto_emergencia"
                                        class="block text-sm font-medium leading-6 text-gray-900">Dirección para
                                        notificarle</label>
                                    <div class="mt-2">
                                        <input wire:model='direccion_contacto_emergencia' type="text" disabled
                                            readonly name="direccion_contacto_emergencia"
                                            id="direccion_contacto_emergencia"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div wire:loading.flex wire:target="aprobar"
                            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                            <div
                                class="animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-indigo-50 bg-transparent">
                            </div>
                        </div>

                        <div
                            class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                            <button type="button" wire:click='abrirModal'
                                class="inline-block rounded-lg bg-danger-200 px-6 pb-2 pt-2.5 font-medium leading-normal text-danger-700 transition duration-150 ease-in-out hover:bg-red-400 focus:bg-red-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200">
                                {{ __('Rechazar') }}
                            </button>
                            <button wire:click='aprobar'
                                class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                {{ __('Aprobar') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
