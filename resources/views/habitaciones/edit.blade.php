<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Habitación') }} N° {{ $habitacion->numero }} — {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('hospedajes.habitaciones.update', [$hospedaje, $habitacion]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="numero" :value="__('Número')" />
                            <x-text-input id="numero" name="numero" type="text"
                                class="mt-1 block w-full" :value="old('numero', $habitacion->numero)" required />
                            <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tipo" :value="__('Tipo')" />
                            <select id="tipo" name="tipo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="simple" {{ old('tipo', $habitacion->tipo) === 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="doble" {{ old('tipo', $habitacion->tipo) === 'doble' ? 'selected' : '' }}>Doble</option>
                                <option value="suite" {{ old('tipo', $habitacion->tipo) === 'suite' ? 'selected' : '' }}>Suite</option>
                                <option value="familiar" {{ old('tipo', $habitacion->tipo) === 'familiar' ? 'selected' : '' }}>Familiar</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="precio" :value="__('Precio (Bs.)')" />
                            <x-text-input id="precio" name="precio" type="number"
                                step="0.01" class="mt-1 block w-full" :value="old('precio', $habitacion->precio)" required />
                            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="capacidad" :value="__('Capacidad (personas)')" />
                            <x-text-input id="capacidad" name="capacidad" type="number"
                                class="mt-1 block w-full" :value="old('capacidad', $habitacion->capacidad)" required />
                            <x-input-error :messages="$errors->get('capacidad')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estado" :value="__('Estado')" />
                            <select id="estado" name="estado"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="disponible" {{ old('estado', $habitacion->estado) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="ocupada" {{ old('estado', $habitacion->estado) === 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                                <option value="mantenimiento" {{ old('estado', $habitacion->estado) === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('hospedajes.show', $hospedaje) }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>