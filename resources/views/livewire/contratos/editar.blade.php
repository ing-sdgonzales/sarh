<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-gray-100 dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalCenterTitle">
                    Editar registro
                </h5>
                <!--Close button-->
                <button type="button" wire:click='cerrarModalEditarContrato'
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6 dark:text-gray-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <form method="POST" wire:submit='editarContrato'>
                @csrf
                <div class="relative p-4">
                    <div class="space-y-12">
                        <div class="pb-6">
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <x-label for="tipo_contratacion" value="{{ __('Tipode contratación') }}" />
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

                                <div class="sm:col-span-3">
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

                                <div class="sm:col-span-full">
                                    <x-label for="secretaria" value="{{ __('Secretaría') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='secretaria' wire:change='getSubsecretariasBySecretaria'
                                            id="secretaria" name="secretaria" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias_nominales as $dependencia)
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
                                            <x-select wire:model='direccion' wire:change='getSubdireccionesByDireccion'
                                                id="direccion" name="direccion" class="block w-full">
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
                                    <x-label for="puesto_nominal" value="{{ __('Puesto nominal') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='puesto_nominal' id="puesto_nominal"
                                            name="puesto_nominal" required wire:change='getSalarioByPuesto'
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($puestos_nominales ?? [] as $puesto_nominal)
                                                <option value="{{ $puesto_nominal->id }}">
                                                    {{ $puesto_nominal->puesto }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto_nominal')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="fecha_inicio" value="{{ __('Fecha de inicio') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_inicio' wire:change='getYearByFechaInicio'
                                            type="date" name="fecha_inicio" id="fecha_inicio" min="1996-11-11"
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_inicio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="fecha_fin" value="{{ __('Fecha de finalización') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_fin' type="date" name="fecha_fin"
                                            id="fecha_fin" min="1996-11-11"
                                            @if (method_exists($this, 'getDisponibilidadPuesto')) wire:change='getDisponibilidadPuesto' @endif
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_fin')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="salario" value="{{ __('Salario u honorarios') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='salario' type="number" name="salario" id="salario"
                                            disabled readonly required min="0" step="0.01"
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('salario')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <x-label for="fianza" value="{{ __('Número de fianza') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fianza' type="text" name="fianza" id="fianza"
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fianza')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <p class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-200"><strong>Número
                                            de contrato</strong>
                                    </p>
                                    <hr>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="contrato_correlativo" value="{{ __('Correlativo') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='contrato_correlativo' type="number"
                                            name="contrato_correlativo" id="contrato_correlativo" required
                                            min="1" step="1" class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('contrato_correlativo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="contrato_renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='contrato_renglon' type="text" name="contrato_renglon"
                                            id="contrato_renglon" required disabled readonly class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('contrato_renglon')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="contrato_year" value="{{ __('Año') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='contrato_year' type="text" name="contrato_year"
                                            id="contrato_year" required disabled readonly class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('contrato_year')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="region" value="{{ __('Región') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='region' id="region" name="region" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($regiones ?? [] as $region)
                                                <option value="{{ $region->id }}">
                                                    {{ $region->region }} - {{ $region->nombre }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('region')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="dependencia_funcional" value="{{ __('Dependencia funcional') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='dependencia_funcional' id="dependencia_funcional"
                                            name="dependencia_funcional" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($dependencias_funcionales ?? [] as $dependencia_funcional)
                                                <option value="{{ $dependencia_funcional->id }}">
                                                    {{ $dependencia_funcional->dependencia }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('dependencia_funcional')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="puesto_funcional" value="{{ __('Puesto Funcional') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='puesto_funcional' id="puesto_funcional"
                                            name="puesto_funcional" class="block w-full">
                                            <option value="">No aplica</option>
                                            @foreach ($puestos_funcionales ?? [] as $puesto_funcional)
                                                <option value="{{ $puesto_funcional->id }}">
                                                    {{ $puesto_funcional->puesto }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('puesto_funcional')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <p class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-200"><strong>Acuerdo
                                            de
                                            aprobación</strong>
                                    </p>
                                    <hr>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="aprobacion_correlativo" value="Correlativo" />
                                    <div class="mt-2">
                                        <x-input wire:model='aprobacion_correlativo' type="number"
                                            name="aprobacion_correlativo" id="aprobacion_correlativo" required
                                            min="1" step="1" class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('aprobacion_correlativo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="aprobacion_renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='aprobacion_renglon' type="text"
                                            name="aprobacion_renglon" id="aprobacion_renglon" required disabled
                                            readonly class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('aprobacion_renglon')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-1">
                                    <x-label for="aprobacion_year" value="{{ __('Año') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='aprobacion_year' type="text" name="aprobacion_year"
                                            id="aprobacion_year" required disabled readonly class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('aprobacion_year')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="nit_autorizacion" value="{{ __('NIT de autorización') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='nit_autorizacion' type="text" name="nit_autorizacion"
                                            id="nit_autorizacion" required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('nit_autorizacion')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <p class="mt-2 text-sm leading-6 text-gray-700 dark:text-gray-200">
                                        <strong>Acuerdo de
                                            rescisión</strong>
                                    </p>
                                    <hr>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="rescicion_correlativo" value="{{ __('Correlativo') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='rescision_correlativo' type="number"
                                            name="rescision_correlativo" id="rescision_correlativo" min="1"
                                            step="1" class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('rescision_correlativo')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="rescision_renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='rescision_renglon' type="text"
                                            name="rescision_renglon" id="rescision_renglon" disabled readonly
                                            class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('rescision_renglon')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="rescision_year" value="{{ __('Año') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='rescision_year' type="text" name="rescision_year"
                                            id="rescision_year" class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('rescision_year')
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
                                    <p class="mt-3 text-sm leading-6 text-gray-700 dark:text-gray-200">Breve
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
                </div>

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-gray-300 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" wire:click='cerrarModalEditarContrato'
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
