<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Reserva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('reservas.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="habitacion_id" :value="__('Habitación')" />
                            <select id="habitacion_id" name="habitacion_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Seleccione una habitación</option>
                                @foreach($habitaciones as $habitacion)
                                    <option value="{{ $habitacion->id }}"
                                        {{ old('habitacion_id') == $habitacion->id ? 'selected' : '' }}>
                                        {{ $habitacion->hospedaje->nombre }} — N° {{ $habitacion->numero }}
                                        ({{ ucfirst($habitacion->tipo) }}) — Bs. {{ number_format($habitacion->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('habitacion_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                            <x-text-input id="fecha_inicio" name="fecha_inicio" type="date"
                                class="mt-1 block w-full" :value="old('fecha_inicio')" required />
                            <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fecha_fin" :value="__('Fecha de Fin')" />
                            <x-text-input id="fecha_fin" name="fecha_fin" type="date"
                                class="mt-1 block w-full" :value="old('fecha_fin')" required />
                            <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('reservas.index') }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Guardar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>