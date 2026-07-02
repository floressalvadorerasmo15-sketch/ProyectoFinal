<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Hospedaje') }}: {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('hospedajes.update', $hospedaje) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="nombre" :value="__('Nombre')" />
                            <x-text-input id="nombre" name="nombre" type="text"
                                class="mt-1 block w-full" :value="old('nombre', $hospedaje->nombre)" required />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="descripcion" :value="__('Descripción')" />
                            <textarea id="descripcion" name="descripcion"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                rows="4">{{ old('descripcion', $hospedaje->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="direccion" :value="__('Dirección')" />
                            <x-text-input id="direccion" name="direccion" type="text"
                                class="mt-1 block w-full" :value="old('direccion', $hospedaje->direccion)" required />
                            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estado" :value="__('Estado')" />
                            <select id="estado" name="estado"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="activo" {{ old('estado', $hospedaje->estado) === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $hospedaje->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="pendiente" {{ old('estado', $hospedaje->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Servicios')" />
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                @foreach($servicios as $servicio)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="servicios[]"
                                            value="{{ $servicio->id }}"
                                            {{ in_array($servicio->id, old('servicios', $serviciosSeleccionados)) ? 'checked' : '' }}
                                            class="rounded border-gray-300">
                                        <span class="text-sm text-gray-700">{{ $servicio->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('servicios')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('hospedajes.index') }}"
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