<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Acceso Denegado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div style="font-size:80px;">🚫</div>
                    <h1 style="font-size:48px; font-weight:bold; color:#dc2626;">403</h1>
                    <p style="font-size:20px; color:#6b7280; margin-top:10px;">
                        No tienes permiso para acceder a esta página.
                    </p>
                    <div style="margin-top:24px;">
                        <a href="{{ route('dashboard') }}"
                            style="background-color:#2563eb; color:#ffffff; padding:10px 24px; border-radius:8px; font-weight:bold; text-decoration:none;">
                            Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>