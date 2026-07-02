<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Reserva') }} #{{ $reserva->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('reservas.update', $reserva) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="habitacion_id" :value="__('Habitación')" />
                            <select id="habitacion_id" name="habitacion_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Seleccione una habitación</option>
                                @foreach($habitaciones as $habitacion)
                                    <option value="{{ $habitacion->id }}"
                                        {{ old('habitacion_id', $reserva->habitacion_id) == $habitacion->id ? 'selected' : '' }}>
                                        {{ $habitacion->hospedaje->nombre }} — N° {{ $habitacion->numero }}
                                        ({{ ucfirst($habitacion->tipo) }}) — Bs. {{ number_format($habitacion->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('habitacion_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                            <input type="date" id="fecha_inicio" name="fecha_inicio"
                                value="{{ old('fecha_inicio', $reserva->fecha_inicio->format('Y-m-d')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required />
                            <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="fecha_fin" :value="__('Fecha de Fin')" />
                            <input type="date" id="fecha_fin" name="fecha_fin"
                                value="{{ old('fecha_fin', $reserva->fecha_fin->format('Y-m-d')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required />
                            <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="estado" :value="__('Estado')" />
                            <select id="estado" name="estado"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="pendiente" {{ old('estado', $reserva->estado) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ old('estado', $reserva->estado) === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ old('estado', $reserva->estado) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="finalizada" {{ old('estado', $reserva->estado) === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('reservas.index') }}"
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
        </div>
    </div>
</x-app-layout>