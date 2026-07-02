<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $hospedaje->nombre }}
            </h2>
            <div class="space-x-2">
                @can('update', $hospedaje)
                    <a href="{{ route('hospedajes.edit', $hospedaje) }}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Editar
                    </a>
                @endcan
                @can('crear habitacion')
                    <a href="{{ route('hospedajes.habitaciones.create', $hospedaje) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Nueva Habitación
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Info del hospedaje -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600">{{ $hospedaje->descripcion }}</p>
                <p class="mt-2"><strong>Dirección:</strong> {{ $hospedaje->direccion }}</p>
                <p class="mt-1"><strong>Estado:</strong>
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $hospedaje->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($hospedaje->estado) }}
                    </span>
                </p>
                @if($hospedaje->servicios->count())
                    <p class="mt-2"><strong>Servicios:</strong>
                        {{ $hospedaje->servicios->pluck('nombre')->join(', ') }}
                    </p>
                @endif
            </div>

            <!-- Habitaciones -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Habitaciones</h3>
                @forelse($hospedaje->habitaciones as $habitacion)
                    <div class="flex justify-between items-center border-b py-2">
                        <div>
                            <span class="font-medium">N° {{ $habitacion->numero }}</span>
                            — {{ ucfirst($habitacion->tipo) }}
                            — Bs. {{ number_format($habitacion->precio, 2) }}
                            — Cap: {{ $habitacion->capacidad }}
                        </div>
                        <div class="space-x-2">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $habitacion->estado === 'disponible' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($habitacion->estado) }}
                            </span>
                            @can('update', $habitacion)
                                <a href="{{ route('hospedajes.habitaciones.edit', [$hospedaje, $habitacion]) }}"
                                    class="text-yellow-600 hover:underline text-sm">Editar</a>
                            @endcan
                            @can('delete', $habitacion)
                                <form action="{{ route('hospedajes.habitaciones.destroy', [$hospedaje, $habitacion]) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('¿Eliminar esta habitación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
                                </form>
                            @endcan
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
                        <div class="flex justify-between">
                            <span class="font-medium">{{ $comentario->user->name }}</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $comentario->calificacion ? '★' : '☆' }}
                                    @endfor
                                </span>
                                @can('delete', $comentario)
                                    <form action="{{ route('hospedajes.comentarios.destroy', [$hospedaje, $comentario]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="text-gray-600 mt-1">{{ $comentario->cuerpo }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No hay comentarios aún.</p>
                @endforelse

                <!-- Formulario de comentario -->
                @can('comentar')
                    <div class="mt-6">
                        <h4 class="font-medium mb-2">Agregar comentario</h4>
                        <form method="POST" action="{{ route('hospedajes.comentarios.store', $hospedaje) }}">
                            @csrf
                            <div class="mb-3">
                                <x-input-label for="calificacion" :value="__('Calificación')" />
                                <select name="calificacion" id="calificacion"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} estrella(s)</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('calificacion')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <x-input-label for="cuerpo" :value="__('Comentario')" />
                                <textarea name="cuerpo" id="cuerpo" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    required>{{ old('cuerpo') }}</textarea>
                                <x-input-error :messages="$errors->get('cuerpo')" class="mt-2" />
                            </div>
                            <x-primary-button>Enviar comentario</x-primary-button>
                        </form>
                    </div>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>