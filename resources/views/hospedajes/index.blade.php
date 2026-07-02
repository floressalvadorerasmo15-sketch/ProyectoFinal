<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hospedajes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @can('crear hospedaje')
                <div class="mb-4">
                    <a href="{{ route('hospedajes.create') }}"
                        style="background-color:#2563eb; color:#ffffff; padding:10px 20px; border-radius:8px; font-weight:bold; text-decoration:none; display:inline-block;">
                        + Nuevo Hospedaje
                    </a>
                </div>
            @endcan

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead style="background-color:#f3f4f6;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dirección</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($hospedajes as $hospedaje)
                                <tr>
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $hospedaje->nombre }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $hospedaje->direccion }}</td>
                                    <td class="px-6 py-4">
                                        @if($hospedaje->estado === 'activo')
                                            <span style="background-color:#d1fae5; color:#065f46; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                                Activo
                                            </span>
                                        @else
                                            <span style="background-color:#fee2e2; color:#991b1b; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                                {{ ucfirst($hospedaje->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('hospedajes.show', $hospedaje) }}"
                                                style="background-color:#3b82f6; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none;">
                                                Ver
                                            </a>
                                            @can('update', $hospedaje)
                                                <a href="{{ route('hospedajes.edit', $hospedaje) }}"
                                                    style="background-color:#f59e0b; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none;">
                                                    Editar
                                                </a>
                                            @endcan
                                            @can('delete', $hospedaje)
                                                <form action="{{ route('hospedajes.destroy', $hospedaje) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('¿Eliminar este hospedaje?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        style="background-color:#ef4444; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; border:none; cursor:pointer;">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No hay hospedajes registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $hospedajes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>