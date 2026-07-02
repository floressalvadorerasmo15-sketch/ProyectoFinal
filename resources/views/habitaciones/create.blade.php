<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Habitación') }} — {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('hospedajes.habitaciones.store', $hospedaje) }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="numero" :value="__('Número')" />
                            <x-text-input id="numero" name="numero" type="text"
                                class="mt-1 block w-full" :value="old('numero')" required />
                            <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tipo" :value="__('Tipo')" />
                            <select id="tipo" name="tipo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="simple" {{ old('tipo') === 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="doble" {{ old('tipo') === 'doble' ? 'selected' : '' }}>Doble</option>
                                <option value="suite" {{ old('tipo') === 'suite' ? 'selected' : '' }}>Suite</option>
                                <option value="familiar" {{ old('tipo') === 'familiar' ? 'selected' : '' }}>Familiar</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="precio" :value="__('Precio (Bs.)')" />
                            <x-text-input id="precio" name="precio" type="number"
                                step="0.01" class="mt-1 block w-full" :value="old('precio')" required />
                            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="capacidad" :value="__('Capacidad (personas)')" />
                            <x-text-input id="capacidad" name="capacidad" type="number"
                                class="mt-1 block w-full" :value="old('capacidad')" required />
                            <x-input-error :messages="$errors->get('capacidad')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estado" :value="__('Estado')" />
                            <select id="estado" name="estado"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="disponible" {{ old('estado') === 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="ocupada" {{ old('estado') === 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                                <option value="mantenimiento" {{ old('estado') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('hospedajes.show', $hospedaje) }}"
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