<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @can('crear reserva')
                <div class="mb-4">
                    <a href="{{ route('reservas.create') }}"
                        style="background-color:#2563eb; color:#ffffff; padding:10px 20px; border-radius:8px; font-weight:bold; text-decoration:none; display:inline-block;">
                        + Nueva Reserva
                    </a>
                </div>
            @endcan

            {{-- Filtros --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('reservas.index') }}">
                    <div style="display:flex; gap:12px; align-items:flex-end;">
                        <div>
                            <label style="font-size:13px; font-weight:600; color:#374151;">Estado</label>
                            <select name="estado"
                                style="display:block; margin-top:4px; padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ request('estado') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="finalizada" {{ request('estado') === 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button type="submit"
                                style="background-color:#2563eb; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; border:none; cursor:pointer;">
                                Filtrar
                            </button>
                            <a href="{{ route('reservas.index') }}"
                                style="background-color:#6b7280; color:#ffffff; padding:8px 16px; border-radius:6px; font-weight:600; text-decoration:none;">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead style="background-color:#f3f4f6;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hospedaje</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Habitación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Fin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reservas as $reserva)
                                <tr>
                                    <td class="px-6 py-4 text-gray-900">{{ $reserva->habitacion->hospedaje->nombre }}</td>
                                    <td class="px-6 py-4 text-gray-600">N° {{ $reserva->habitacion->numero }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $reserva->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $reserva->fecha_fin->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if($reserva->estado === 'confirmada')
                                            <span style="background-color:#d1fae5; color:#065f46; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">Confirmada</span>
                                        @elseif($reserva->estado === 'cancelada')
                                            <span style="background-color:#fee2e2; color:#991b1b; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">Cancelada</span>
                                        @elseif($reserva->estado === 'finalizada')
                                            <span style="background-color:#e0e7ff; color:#3730a3; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">Finalizada</span>
                                        @else
                                            <span style="background-color:#fef3c7; color:#92400e; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('reservas.show', $reserva) }}"
                                                style="background-color:#3b82f6; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none;">
                                                Ver
                                            </a>
                                            @can('update', $reserva)
                                                <a href="{{ route('reservas.edit', $reserva) }}"
                                                    style="background-color:#f59e0b; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none;">
                                                    Editar
                                                </a>
                                            @endcan
                                            @can('delete', $reserva)
                                                @if($reserva->estado !== 'cancelada')
                                                    <form action="{{ route('reservas.destroy', $reserva) }}"
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('¿Cancelar esta reserva?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            style="background-color:#ef4444; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; border:none; cursor:pointer;">
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No hay reservas registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $reservas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>