<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComentarioRequest;
use App\Models\Comentario;
use App\Models\Hospedaje;
use Illuminate\Routing\Attributes\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

#[Middleware('auth')]
#[Middleware('permission:comentar', only: ['store'])]
class ComentarioController extends Controller
{
    public function store(StoreComentarioRequest $request, Hospedaje $hospedaje)
    {
        $hospedaje->comentarios()->create([
            'user_id' => Auth::id(),
            'cuerpo' => $request->cuerpo,
            'calificacion' => $request->calificacion,
        ]);

        return redirect()->route('hospedajes.show', $hospedaje)
            ->with('success', 'Comentario agregado correctamente.');
    }

    public function destroy(Hospedaje $hospedaje, Comentario $comentario)
    {
        Gate::authorize('delete', $comentario);
        $comentario->delete();

        return redirect()->route('hospedajes.show', $hospedaje)
            ->with('success', 'Comentario eliminado correctamente.');
    }
}