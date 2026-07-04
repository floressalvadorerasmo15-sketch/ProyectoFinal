<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Hospedaje') }}: {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Formulario editar hospedaje -->
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
                                style="background-color:#6b7280; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; text-decoration:none;">
                                Cancelar
                            </a>
                            <button type="submit"
                                style="background-color:#2563eb; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; border:none; cursor:pointer;">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gestión de habitaciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                        <h3 class="text-lg font-semibold">Habitaciones</h3>
                        <a href="{{ route('hospedajes.habitaciones.create', $hospedaje) }}"
                            style="background-color:#16a34a; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; text-decoration:none;">
                            + Agregar Habitación
                        </a>
                    </div>

                    @forelse($hospedaje->habitaciones as $habitacion)
                        <div class="flex justify-between items-center border-b py-2">
                            <div>
                                <span class="font-medium">N° {{ $habitacion->numero }}</span>
                                — {{ ucfirst($habitacion->tipo) }}
                                — Bs. {{ number_format($habitacion->precio, 2) }}
                                — Cap: {{ $habitacion->capacidad }} personas
                            </div>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <span style="padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;
                                    {{ $habitacion->estado === 'disponible' ? 'background-color:#d1fae5; color:#065f46;' : 'background-color:#fee2e2; color:#991b1b;' }}">
                                    {{ ucfirst($habitacion->estado) }}
                                </span>
                                <a href="{{ route('hospedajes.habitaciones.edit', [$hospedaje, $habitacion]) }}"
                                    style="background-color:#f59e0b; color:#ffffff; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;">
                                    Editar
                                </a>
                                <form action="{{ route('hospedajes.habitaciones.destroy', [$hospedaje, $habitacion]) }}"
                                    method="POST" style="display:inline;"
                                    onsubmit="return confirm('¿Eliminar esta habitación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background-color:#ef4444; color:#ffffff; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; border:none; cursor:pointer;">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No hay habitaciones registradas. Agrega la primera.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>