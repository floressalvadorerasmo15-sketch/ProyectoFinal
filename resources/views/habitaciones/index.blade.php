<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Habitaciones — {{ $hospedaje->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="display:flex; gap:8px; margin-bottom:16px;">
                <a href="{{ route('hospedajes.edit', $hospedaje) }}"
                    style="background-color:#6b7280; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; text-decoration:none;">
                    ← Volver
                </a>
                @can('crear habitacion')
                    <a href="{{ route('hospedajes.habitaciones.create', $hospedaje) }}"
                        style="background-color:#16a34a; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; text-decoration:none;">
                        + Agregar Habitación
                    </a>
                @endcan
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($habitaciones as $habitacion)
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
                                @can('update', $habitacion)
                                    <a href="{{ route('hospedajes.habitaciones.edit', [$hospedaje, $habitacion]) }}"
                                        style="background-color:#f59e0b; color:#ffffff; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;">
                                        Editar
                                    </a>
                                @endcan
                                @can('delete', $habitacion)
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
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No hay habitaciones registradas.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $habitaciones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>