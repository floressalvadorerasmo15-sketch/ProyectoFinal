<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Middleware;
use Spatie\Permission\Models\Role;

#[Middleware('auth')]
#[Middleware('role:admin')]
class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->latest()->paginate(10);
        return view('admin.users.index', compact('usuarios'));
    }

    public function show(User $user)
    {
        $user->load('roles');
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'rol' => 'required|exists:roles,name',
        ]);

        $user->syncRoles($request->rol);

        return redirect()->route('admin.users.index')
            ->with('success', 'Rol actualizado correctamente.');
    }
}