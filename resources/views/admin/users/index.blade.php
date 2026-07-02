<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead style="background-color:#f3f4f6;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($usuarios as $usuario)
                                <tr>
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $usuario->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $usuario->email }}</td>
                                    <td class="px-6 py-4">
                                        @foreach($usuario->roles as $rol)
                                            <span style="background-color:#dbeafe; color:#1e40af; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                                {{ ucfirst($rol->name) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', $usuario) }}"
                                            style="background-color:#3b82f6; color:#ffffff; padding:6px 14px; border-radius:6px; font-size:13px; font-weight:600; text-decoration:none;">
                                            Gestionar Rol
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No hay usuarios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>