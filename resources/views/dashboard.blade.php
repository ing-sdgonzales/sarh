<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 h-full">
        <div class="w-full mx-auto sm:px-6 lg:px-8 h-screen">
            <iframe class="rounded-lg" src="{{ route('prueba') }}" frameborder="0" allowfullscreen
                style="position:relative;
                top:0;
                left:0;
                width:100%;
                height:100%;"></iframe>{{-- 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg w-full">
                
            </div> --}}
        </div>
    </div>
    @push('js')
    @endpush
</x-app-layout>
