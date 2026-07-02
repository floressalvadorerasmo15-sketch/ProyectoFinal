<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Reserva') }} #{{ $reserva->id }}
            </h2>
            <div class="space-x-2">
                @can('update', $reserva)
                    <a href="{{ route('reservas.edit', $reserva) }}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Editar
                    </a>
                @endcan
                @can('cancel', $reserva)
                    @if($reserva->estado !== 'cancelada')
                        <form action="{{ route('reservas.destroy', $reserva) }}"
                            method="POST" class="inline"
                            onsubmit="return confirm('¿Cancelar esta reserva?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar Reserva
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Hospedaje</p>
                        <p class="font-medium">{{ $reserva->habitacion->hospedaje->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Habitación</p>
                        <p class="font-medium">N° {{ $reserva->habitacion->numero }} — {{ ucfirst($reserva->habitacion->tipo) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Cliente</p>
                        <p class="font-medium">{{ $reserva->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $reserva->estado === 'confirmada' ? 'bg-green-100 text-green-800' :
                               ($reserva->estado === 'cancelada' ? 'bg-red-100 text-red-800' :
                               'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($reserva->estado) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fecha Inicio</p>
                        <p class="font-medium">{{ $reserva->fecha_inicio->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fecha Fin</p>
                        <p class="font-medium">{{ $reserva->fecha_fin->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Precio por noche</p>
                        <p class="font-medium">Bs. {{ number_format($reserva->habitacion->precio, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total estimado</p>
                        <p class="font-medium">Bs. {{ number_format($reserva->habitacion->precio * $reserva->fecha_inicio->diffInDays($reserva->fecha_fin), 2) }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('reservas.index') }}"
                        class="text-blue-600 hover:underline">← Volver a reservas</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>