<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestionar Rol') }} — {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Rol actual:</strong>
                            @foreach($user->roles as $rol)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ $rol->name }}
                                </span>
                            @endforeach
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <x-input-label for="rol" :value="__('Asignar Rol')" />
                            <select id="rol" name="rol" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->name }}"
                                        {{ $user->hasRole($rol->name) ? 'selected' : '' }}>
                                        {{ ucfirst($rol->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('admin.users.index') }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                Volver
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Rol') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>