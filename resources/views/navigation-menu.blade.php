@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                @if (auth()->user()->hasRole('Empleado'))
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard-empleados') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('dashboard-empleados') }}" :active="request()->routeIs('dashboard-empleados')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </div>

                    <!-- Dropdown Solicitudes -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                                <button type="button" @click="isOpen = !isOpen"
                                    class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400"
                                    aria-expanded="false">
                                    <span>{{ __('Solicitudes') }}</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4 origin-top-right">
                                    <div
                                        class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                        <div class="p-4">
                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('empleados-solicitudes-vacaciones') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Solicitar vacaciones') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Control y solicitudes de vacaciones
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                    </svg>

                                                </div>
                                                <div>
                                                    <a href="{{ route('vacaciones') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Solicitar permiso') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Control y solicitudes de permisos
                                                        laborales
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('vacaciones') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Solicitar constancia laboral') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Solicitudes de consntancias laborales
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Otras opciones de menú -->
                                        </div>
                                        {{-- <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Watch demo
                                        </a>
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.950a11.542 11.542 0 006.254 6.254c.395.163.833-.07.950-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Contact sales
                                        </a>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->hasRole('Súper Administrador') ||
                        auth()->user()->hasRole('Administrador') ||
                        auth()->user()->hasRole('Operativo'))
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </div>

                    <!-- Dropdown Reclutamiento -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                                <button type="button" @click="isOpen = !isOpen"
                                    class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400"
                                    aria-expanded="false">
                                    <span>{{ __('Dotación de personal') }}</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4 origin-top-right">
                                    <div
                                        class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                        <div class="p-4">
                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('candidatos') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Reclutamiento') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Gestión de candidatos
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('empleados') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Empleados') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Administración de empleados
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                    </svg>

                                                </div>
                                                <div>
                                                    <a href="{{ route('requisitos') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Requisitos') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Gestión de requisitos
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg class="h-6 w-6 text-gray-600 group-hover:text-indigo-600"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('puestos') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Administración de puestos') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Administración de puestos
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        data-slot="icon"
                                                        class="h-6 w-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                                    </svg>

                                                </div>
                                                <div>
                                                    <a href="{{ route('catalogo_puestos') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Catálogo de puestos') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Denominación general de puestos y su
                                                        disponibilidad
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Otras opciones de menú -->
                                        </div>
                                        {{-- <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Watch demo
                                        </a>
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.950a11.542 11.542 0 006.254 6.254c.395.163.833-.07.950-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Contact sales
                                        </a>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Acciones de Personal -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                                <button type="button" @click="isOpen = !isOpen"
                                    class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400"
                                    aria-expanded="false">
                                    <span>{{ __('Acciones de personal') }}</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4 origin-top-right">
                                    <div
                                        class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                        <div class="p-4">
                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('vacaciones') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Gestión de vacaciones') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Gestión de candidatos
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Otras opciones de menú -->
                                        </div>
                                        {{-- <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Watch demo
                                        </a>
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.950a11.542 11.542 0 006.254 6.254c.395.163.833-.07.950-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Contact sales
                                        </a>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Bienestar Laboral -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                                <button type="button" @click="isOpen = !isOpen"
                                    class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400"
                                    aria-expanded="false">
                                    <span>{{ __('Bienestar laboral') }}</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4 origin-top-right">
                                    <div
                                        class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                        <div class="p-4">
                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        data-slot="icon"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <a href="{{ route('capacitaciones') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Capacitaciones') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Sesiones de capacitación para los
                                                        empleados
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.712 4.33a9.027 9.027 0 0 1 1.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 0 0-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 0 1 0 9.424m-4.138-5.976a3.736 3.736 0 0 0-.88-1.388 3.737 3.737 0 0 0-1.388-.88m2.268 2.268a3.765 3.765 0 0 1 0 2.528m-2.268-4.796a3.765 3.765 0 0 0-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 0 1-1.388.88m2.268-2.268 4.138 3.448m0 0a9.027 9.027 0 0 1-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0-3.448-4.138m3.448 4.138a9.014 9.014 0 0 1-9.424 0m5.976-4.138a3.765 3.765 0 0 1-2.528 0m0 0a3.736 3.736 0 0 1-1.388-.88 3.737 3.737 0 0 1-.88-1.388m2.268 2.268L7.288 19.67m0 0a9.024 9.024 0 0 1-1.652-1.306 9.027 9.027 0 0 1-1.306-1.652m0 0 4.138-3.448M4.33 16.712a9.014 9.014 0 0 1 0-9.424m4.138 5.976a3.765 3.765 0 0 1 0-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 0 1 1.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.288 4.33m0 0a9.024 9.024 0 0 0-1.652 1.306A9.025 9.025 0 0 0 4.33 7.288" />
                                                    </svg>

                                                </div>
                                                <div>
                                                    <a href="{{ route('inducciones') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Inducciones') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Empleados pendientes de capacitación
                                                        de
                                                        inducción
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Item -->
                                            <div class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                <div
                                                    class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        data-slot="icon"
                                                        class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                                    </svg>

                                                </div>
                                                <div>
                                                    <a href="{{ route('historial_medico') }}"
                                                        class="font-semibold text-gray-900">
                                                        {{ __('Historial médico') }}
                                                        <span class="absolute inset-0"></span>
                                                    </a>
                                                    <p class="mt-1 text-gray-600">Registro de consultas médicas e
                                                        información clínica del empleado
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Otras opciones de menú -->
                                        </div>
                                        {{-- <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Watch demo
                                        </a>
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.950a11.542 11.542 0 006.254 6.254c.395.163.833-.07.950-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Contact sales
                                        </a>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Nóminas -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div
                            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                                <button type="button" @click="isOpen = !isOpen"
                                    class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400"
                                    aria-expanded="false">
                                    <span>{{ __('Nóminas') }}</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4 origin-top-right">
                                    <div
                                        class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                        <div class="p-4">

                                            <!-- Otras opciones de menú -->
                                        </div>
                                        {{-- <div class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50">
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 10a8 8 0 1116 0 8 8 0 01-16 0zm6.39-2.908a.75.75 0 01.766.027l3.5 2.25a.75.75 0 010 1.262l-3.5 2.25A.75.75 0 018 12.25v-4.5a.75.75 0 01.39-.658z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Watch demo
                                        </a>
                                        <a href="#"
                                            class="flex items-center justify-center gap-x-2.5 p-3 font-semibold text-gray-900 hover:bg-gray-100">
                                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.950a11.542 11.542 0 006.254 6.254c.395.163.833-.07.950-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Contact sales
                                        </a>
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('formulario_pir') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('formulario_pir') }}" :active="request()->routeIs('formulario_pir')">
                            {{ __('Formulario PIR') }}
                        </x-nav-link>
                    </div>

                    @if (auth()->user()->hasRole('Dirección de Recursos Humanos'))
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('control_pir') }}" :active="request()->routeIs('control_pir')">
                                {{ __('Control de reportes') }}
                            </x-nav-link>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <div
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                                    <button type="button" @click="isOpen = !isOpen"
                                        class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 dark:text-gray-400"
                                        aria-expanded="false">
                                        <span>{{ __('Empleados') }}</span>
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-1"
                                        class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4 origin-top-right">
                                        <div
                                            class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <!-- Item -->
                                                <div
                                                    class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                    <div
                                                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('personal_pir') }}"
                                                            class="font-semibold text-gray-900">
                                                            {{ __('Personal') }}
                                                            <span class="absolute inset-0"></span>
                                                        </a>
                                                        <p class="mt-1 text-gray-600">Personal de renglones 011, 021,
                                                            022 y
                                                            031
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Item -->
                                                <div
                                                    class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50">
                                                    <div
                                                        class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-6 h-6 text-gray-600 group-hover:text-indigo-600">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('contratistas_pir') }}"
                                                            class="font-semibold text-gray-900">
                                                            {{ __('Contratistas') }}
                                                            <span class="absolute inset-0"></span>
                                                        </a>
                                                        <p class="mt-1 text-gray-600">Prestadores de servicio de
                                                            renglón 029
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Otras opciones de menú -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Teams Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            @hasanyrole('Súper Administrador|Administrador')
                                <!-- User Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Users') }}
                                </div>
                                <x-dropdown-link href="{{ route('usuarios') }}">
                                    {{ __('Users') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('roles') }}">
                                    {{ __('Roles') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('permisos') }}">
                                    {{ __('Permissions') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('bitacora') }}">
                                    {{ __('Bitácora') }}
                                </x-dropdown-link>
                            @endhasanyrole
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            @if (auth()->user()->hasRole('Empleado'))
                <x-responsive-nav-link href="{{ route('dashboard-empleados') }}" :active="request()->routeIs('dashboard-empleados')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                {{-- Dropdown Solicitudes --}}
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-responsive-nav-link href="#">
                            {{ __('Solicitudes') }}
                        </x-responsive-nav-link>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('candidatos') }}" :active="request()->routeIs('candidatos')">
                            {{ __('Solicitar vacaciones') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('empleados') }}" :active="request()->routeIs('empleados')">
                            {{ __('Solicitar permiso') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('requisitos') }}" :active="request()->routeIs('requisitos')">
                            {{ __('Solicitar constancia laboral') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            @elseif(auth()->user()->hasRole('Súper Administrador') ||
                    auth()->user()->hasRole('Administrador') ||
                    auth()->user()->hasRole('Operativo'))
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                {{-- Dropdown Dotación de personal --}}
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-responsive-nav-link href="#">
                            {{ __('Dotación de personal') }}
                        </x-responsive-nav-link>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('candidatos') }}" :active="request()->routeIs('candidatos')">
                            {{ __('Reclutamiento') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('empleados') }}" :active="request()->routeIs('empleados')">
                            {{ __('Empleados') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('requisitos') }}" :active="request()->routeIs('requisitos')">
                            {{ __('Requisitos') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('puestos') }}" :active="request()->routeIs('puestos')">
                            {{ __('Administración de puestos') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('catalogo_puestos') }}" :active="request()->routeIs('catalogo_puestos')">
                            {{ __('Catálogo de puestos') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                {{-- Dropdown Acciones de personal --}}
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-responsive-nav-link href="#">
                            {{ __('Acciones de personal') }}
                        </x-responsive-nav-link>
                    </x-slot>
                    <x-slot name="content">
                        {{-- <x-dropdown-link href="{{ route('candidatos') }}" :active="request()->routeIs('candidatos')">
                            {{ __('Reclutamiento') }}
                        </x-dropdown-link> --}}
                    </x-slot>
                </x-dropdown>

                {{-- Dropdown Bienestar laboral --}}
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-responsive-nav-link href="#">
                            {{ __('Bienestar laboral') }}
                        </x-responsive-nav-link>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('capacitaciones') }}" :active="request()->routeIs('capacitaciones')">
                            {{ __('Capacitaciones') }}
                        </x-dropdown-link>
                        <x-dropdown-link {{-- href="{{ route('capacitaciones') }}" :active="request()->routeIs('capacitaciones')" --}}>
                            {{ __('Historial médico') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                {{-- Dropdown Dotación de personal --}}
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-responsive-nav-link href="#">
                            {{ __('Nóminas') }}
                        </x-responsive-nav-link>
                    </x-slot>
                    <x-slot name="content">
                        {{--  <x-dropdown-link href="{{ route('candidatos') }}" :active="request()->routeIs('candidatos')">
                            {{ __('Reclutamiento') }}
                        </x-dropdown-link> --}}
                    </x-slot>
                </x-dropdown>
            @else
                <x-responsive-nav-link href="{{ route('formulario_pir') }}" :active="request()->routeIs('formulario_pir')">
                    {{ __('Formulario PIR') }}
                </x-responsive-nav-link>
                @role('Dirección de Recursos Humanos')
                    <x-responsive-nav-link href="{{ route('control_pir') }}" :active="request()->routeIs('control_pir')">
                        {{ __('Control de reportes') }}
                    </x-responsive-nav-link>
                    
                    <x-dropdown>
                        <x-slot name="trigger">
                            <x-responsive-nav-link href="#">
                                {{ __('Empleados') }}
                            </x-responsive-nav-link>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('personal_pir') }}" :active="request()->routeIs('personal_pir')">
                                {{ __('Personal') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('contratistas_pir') }}" :active="request()->routeIs('contratistas_pir')">
                                {{ __('Contratistas') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                @endrole
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <!-- Account Management -->
                @hasanyrole('Súper Administrador|Administrador')
                    <!-- User Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Users') }}
                    </div>
                    <x-responsive-nav-link href="{{ route('usuarios') }}" :active="request()->routeIs('usuarios')">
                        {{ __('Users') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('roles') }}" :active="request()->routeIs('roles')">
                        {{ __('Roles') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('permisos') }}" :active="request()->routeIs('permisos')">
                        {{ __('Permissions') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('bitacora') }}" :active="request()->routeIs('bitacora')">
                        {{ __('Bitácora') }}
                    </x-responsive-nav-link>
                @endhasanyrole

                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Account') }}
                </div>

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
