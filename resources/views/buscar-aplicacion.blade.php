<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('buscar_aplicacion') }}">
            @csrf

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Search') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
    @push('js')
        <script>
            Swal.fire({
                title: "¡Bienvenido!",
                html: `
                <h1><strong>Sistema de Administración de Recursos Humanos</strong></h1>
                <p>Utiliza esta plataforma para cargar y gestionar tus requisitos de manera eficiente.</p>
                `,
                text: "Sistema de Administración de Recursos Humanos",
                imageUrl: "{{ asset('/img/logoalt.svg') }}",
                imageWidth: 85,
                imageHeight: 85,
                imageAlt: "SE-CONRED",
                confirmButtonColor: '#1F2937'
            });
        </script>
    @endpush
</x-guest-layout>
