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
                <form method="POST">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 dark:border-gray-500 pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-200">Información
                                del puesto</h2>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-1">
                                    <x-label for="codigo" value="{{ __('Código') }}" />
                                    <div class="mt-2">
                                        <x-input id="codigo" type="number" class="mt-1 block w-full"
                                            wire:model="codigo" min="0" step="1" required />
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
                                    <x-label for="renglon" value="{{ __('Renglón') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='renglon' wire:change='getPuestosByRenglon' id="renglon"
                                            name="renglón" class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($renglones as $renglon)
                                                <option value="{{ $renglon->id }}">{{ $renglon->renglon }} -
                                                    {{ $renglon->nombre }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('renglon')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="puesto" value="{{ __('Puesto') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='puesto' id="puesto" name="puesto" class="block w-full"
                                            required>
                                            <option value="">Seleccionar...</option>
                                            @foreach ($catalogo_puestos as $cpuesto)
                                                <option value="{{ $cpuesto->id }}">{{ $cpuesto->codigo }} -
                                                    {{ $cpuesto->puesto }}
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

                                <div class="sm:col-span-4">
                                    <x-label for="partida" value="{{ __('Partida presupuestaria') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='partida' id="partida" name="partida_presupuestaria"
                                            type="text" required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('partida')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="fecha_registro" value="{{ __('Fecha de registro') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model='fecha_registro' id="fecha_registro" name="fecha_registro"
                                            type="date" required class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fecha_registro')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="region" value="{{ __('Región') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model="region" wire:change="getDepartamentosByRegion"
                                            id="region" name="región" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($regiones as $region)
                                                <option value="{{ $region->id }}">{{ $region->region }} -
                                                    {{ $region->nombre }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600
                                            text-sm">
                                            @error('region')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="departamento" value="{{ __('Departamento') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model="departamento" wire:change="getMunicipiosByDepartamento"
                                            id="departamento" name="departamento" required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($departamentos_region ?? [] as $departamento)
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

                                <div class="sm:col-span-2">
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

                                <div class="sm:col-span-2">
                                    <x-label for="especialidad" value="{{ __('Especialidad') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='especialidad' id="especialidad" name="especialidad"
                                            required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($especialidades as $especialidad)
                                                <option value="{{ $especialidad->id }}">
                                                    {{ $especialidad->especialidad }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('especialidad')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="fuentes_financiamientos"
                                        value="{{ __('Fuentes de financiamiento') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='fuentes_financiamientos' id="fuentes_financiamientos"
                                            required name="fuentes_financiamientos" class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($fuentes as $fuente)
                                                <option value="{{ $fuente->id }}">{{ $fuente->codigo }} -
                                                    {{ $fuente->fuente }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('fuentes_financiamientos')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-label for="plaza" value="{{ __('Plaza') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='plaza' id="plaza" name="plaza" required
                                            class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($plazas as $plaza)
                                                <option value="{{ $plaza->id }}">{{ $plaza->plaza }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600
                                            text-sm">
                                            @error('plaza')
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
                                    <x-label for="subproducto" value="{{ __('Subproducto') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='subproducto' id="subproducto" name="subproducto"
                                            required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($subproductos ?? [] as $subproducto)
                                                <option value="{{ $subproducto->id }}">
                                                    {{ $subproducto->codigo }} - {{ $subproducto->proyecto }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600 text-sm">
                                            @error('subproducto')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-label for="tipo_servicio" value="{{ __('Tipo de servicio') }}" />
                                    <div class="mt-2">
                                        <x-select wire:model='tipo_servicio' id="tipo_servicio" name="tipo_servicio"
                                            required class="block w-full">
                                            <option value="">Seleccionar...</option>
                                            @foreach ($tipos_servicios as $servicio)
                                                <option value="{{ $servicio->id }}">
                                                    {{ $servicio->tipo_servicio }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div>
                                        <span class="text-red-600
                                            text-sm">
                                            @error('tipo_servicio')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">


                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <x-checkbox wire:model='financiado' id="financiado" name="financiado"
                                                type="checkbox" value="1"></x-checkbox>
                                        </div>
                                        <div class="text-sm leading-6">
                                            <x-label for="financiado" value="{{ __('Financiado') }}" />
                                            <p class="text-gray-500 dark:text-gray-200">Indicador cuando un puesto esta
                                                dentro del
                                                financiamiento
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-200"">Salario y
                                Bonificaciones</h2>
                            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-3">
                                    <x-label for="salario" value="{{ __('Salario base u honorarios (Q)') }}" />
                                    <div class="mt-2">
                                        <x-input wire:model.live='salario' id="salario" name="salario"
                                            type="number" step="0.01" min="0" pattern="^\d+(\.\d{1,2})?$"
                                            required value="0.00" class="block w-full" />
                                    </div>
                                    <div>
                                        <span class="text-red-600
                                            text-sm">
                                            @error('salario')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <table
                                        class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden text-center ring-1 ring-gray-300 dark:ring-gray-600">
                                        <thead class="bg-gray-300 dark:bg-gray-800 text-center">
                                            <tr class="text-gray-800 dark:text-gray-300">
                                                <th class="w-1/12 py-2 px-4">Cantidad</th>
                                                <th class="w-1/12 py-2 px-4">Bono</th>
                                                <th class="w-1/4 py-2 px-4">Renglón</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-600">
                                            @foreach ($bonos as $bn)
                                                <tr class="text-gray-800 dark:text-gray-200"
                                                    wire:key='{{ 'bono' . $bn->id }}'>
                                                    <td class="py-2 px-4 items-center">
                                                        <div class="relative flex gap-x-20">
                                                            <div class="flex h-6 items-center">
                                                                <x-checkbox wire:model='bono'
                                                                    wire:key='bono_chk{{ $bn->id }}'
                                                                    wire:change='actualizarBonos' type="checkbox"
                                                                    id="bono-{{ $bn->id }}"
                                                                    value="{{ $bn->id }}" class="h-4 w-4" />
                                                            </div>
                                                            <div
                                                                class="text-sm
                                                                    leading-6">
                                                                <label for="bono-{{ $bn->id }}">
                                                                    @if ($bn->bono == 'Bono por disponibilidad y riesgo')
                                                                        @if ($salario != '')
                                                                            Q
                                                                            {{ number_format($salario * $bn->cantidad, 2, '.', '') }}
                                                                        @else
                                                                            Q {{ $bn->cantidad }}
                                                                        @endif
                                                                    @elseif($bn->bono == 'Aguinaldo')
                                                                        @if ($aguinaldo != '')
                                                                            Q
                                                                            {{ number_format($aguinaldo, 2, '.', '') }}
                                                                        @else
                                                                            Q {{ $bn->cantidad }}
                                                                        @endif
                                                                    @elseif($bn->bono == 'Bono 14')
                                                                        @if ($bono14 != '')
                                                                            Q
                                                                            {{ number_format($bono14, 2, '.', '') }}
                                                                        @else
                                                                            Q {{ $bn->cantidad }}
                                                                        @endif
                                                                    @else
                                                                        Q {{ $bn->cantidad }}
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-2 px-4">{{ $bn->bono }}</td>
                                                    <td class="py-2 px-4">{{ $bn->renglon }} - {{ $bn->nombre }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                <button type="submit" wire:click='guardar'
                    class="ml-1 inline-block rounded-lg bg-primary px-6 pb-2 pt-2.5 font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </div>
</div>
