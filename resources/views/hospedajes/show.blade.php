<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div>
                <a href="{{ route('hospedajes.index') }}"
                    style="background-color:#6b7280; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; text-decoration:none;">
                    ← Volver
                </a>
            </div>

            <!-- Info del hospedaje -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Información del Hospedaje</h3>
                <p class="text-gray-600">{{ $hospedaje->descripcion }}</p>
                <p class="mt-2"><strong>Dirección:</strong> {{ $hospedaje->direccion }}</p>
                <p class="mt-1"><strong>Estado:</strong>
                    <span style="padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;
                        {{ $hospedaje->estado === 'activo' ? 'background-color:#d1fae5; color:#065f46;' : 'background-color:#fee2e2; color:#991b1b;' }}">
                        {{ ucfirst($hospedaje->estado) }}
                    </span>
                </p>
                @if($hospedaje->servicios->count())
                    <p class="mt-2"><strong>Servicios:</strong>
                        {{ $hospedaje->servicios->pluck('nombre')->join(', ') }}
                    </p>
                @endif
            </div>

            <!-- Habitaciones - solo info y botón reservar -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Habitaciones</h3>
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
                            @if((Auth::user()->hasRole('cliente') || Auth::user()->hasRole('recepcionista')) && $habitacion->estado === 'disponible')
                                <a href="{{ route('reservas.create', ['habitacion_id' => $habitacion->id]) }}"
                                    style="background-color:#16a34a; color:#ffffff; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;">
                                    Reservar
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No hay habitaciones registradas.</p>
                @endforelse
            </div>

            <!-- Comentarios -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Comentarios y Calificaciones</h3>

                @forelse($hospedaje->comentarios as $comentario)
                    <div class="border-b py-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-medium">{{ $comentario->user->name }}</span>
                                <span class="text-yellow-500 ml-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $comentario->calificacion ? '★' : '☆' }}
                                    @endfor
                                </span>
                            </div>
                            <div style="display:flex; gap:8px;">
                                @role('admin')
                                    <form action="{{ route('hospedajes.comentarios.destroy', [$hospedaje, $comentario]) }}"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('¿Eliminar este comentario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background-color:#ef4444; color:#ffffff; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; border:none; cursor:pointer;">
                                            Eliminar
                                        </button>
                                    </form>
                                @endrole
                                @if(Auth::id() === $comentario->user_id && Auth::user()->hasRole('cliente'))
                                    <form action="{{ route('hospedajes.comentarios.destroy', [$hospedaje, $comentario]) }}"
                                        method="POST" style="display:inline;"
                                        onsubmit="return confirm('¿Eliminar tu comentario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background-color:#ef4444; color:#ffffff; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; border:none; cursor:pointer;">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-600 mt-1">{{ $comentario->cuerpo }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No hay comentarios aún.</p>
                @endforelse

                @if(Auth::user()->hasRole('cliente') || Auth::user()->hasRole('propietario'))
                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-medium mb-2">
                            @role('propietario')
                                Responder a los comentarios
                            @endrole
                            @role('cliente')
                                ¿Cómo fue tu experiencia en {{ $hospedaje->nombre }}?
                            @endrole
                        </h4>
                        <form method="POST" action="{{ route('hospedajes.comentarios.store', $hospedaje) }}">
                            @csrf
                            @role('cliente')
                                <div class="mb-3">
                                    <x-input-label for="calificacion" :value="__('Calificación')" />
                                    <select name="calificacion" id="calificacion"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="1">⭐ 1 - Muy malo</option>
                                        <option value="2">⭐⭐ 2 - Malo</option>
                                        <option value="3">⭐⭐⭐ 3 - Regular</option>
                                        <option value="4">⭐⭐⭐⭐ 4 - Bueno</option>
                                        <option value="5" selected>⭐⭐⭐⭐⭐ 5 - Excelente</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('calificacion')" class="mt-2" />
                                </div>
                            @endrole
                            @role('propietario')
                                <input type="hidden" name="calificacion" value="5">
                            @endrole
                            <div class="mb-3">
                                <x-input-label for="cuerpo" :value="__('Comentario')" />
                                <textarea name="cuerpo" id="cuerpo" rows="4"
                                    placeholder="{{ Auth::user()->hasRole('propietario') ? 'Escribe tu respuesta...' : 'Cuéntanos cómo fue tu estadía...' }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    required>{{ old('cuerpo') }}</textarea>
                                <x-input-error :messages="$errors->get('cuerpo')" class="mt-2" />
                            </div>
                            <button type="submit"
                                style="background-color:#2563eb; color:#ffffff; padding:8px 20px; border-radius:6px; font-weight:600; border:none; cursor:pointer;">
                                {{ Auth::user()->hasRole('propietario') ? 'Responder' : 'Enviar comentario' }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>