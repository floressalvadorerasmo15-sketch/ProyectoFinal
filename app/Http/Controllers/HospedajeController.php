<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHospedajeRequest;
use App\Http\Requests\UpdateHospedajeRequest;
use App\Models\Hospedaje;
use App\Models\Servicio;
use Illuminate\Routing\Attributes\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

#[Middleware('auth')]
#[Middleware('permission:ver hospedaje', only: ['index', 'show'])]
#[Middleware('permission:crear hospedaje', only: ['create', 'store'])]
#[Middleware('permission:editar hospedaje', only: ['edit', 'update'])]
#[Middleware('permission:eliminar hospedaje', only: ['destroy'])]
class HospedajeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hospedajes = $user->hasRole('admin')
            ? Hospedaje::with('owner')->latest()->paginate(10)
            : Hospedaje::where('owner_id', $user->id)->latest()->paginate(10);

        return view('hospedajes.index', compact('hospedajes'));
    }

    public function create()
    {
        $servicios = Servicio::all();
        return view('hospedajes.create', compact('servicios'));
    }

    public function store(StoreHospedajeRequest $request)
    {
        $hospedaje = Hospedaje::create([
            'owner_id' => Auth::id(),
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'estado' => $request->estado,
        ]);

        if ($request->has('servicios')) {
            $hospedaje->servicios()->attach($request->servicios);
        }

        $hospedaje->usuarios()->attach(Auth::id(), ['rol_hospedaje' => 'propietario']);

        return redirect()->route('hospedajes.index')
            ->with('success', 'Hospedaje creado correctamente.');
    }

    public function show(Hospedaje $hospedaje)
    {
        $hospedaje->load('habitaciones', 'servicios', 'comentarios.user');
        return view('hospedajes.show', compact('hospedaje'));
    }

    public function edit(Hospedaje $hospedaje)
    {
        Gate::authorize('update', $hospedaje);
        $servicios = Servicio::all();
        $serviciosSeleccionados = $hospedaje->servicios->pluck('id')->toArray();
        return view('hospedajes.edit', compact('hospedaje', 'servicios', 'serviciosSeleccionados'));
    }

    public function update(UpdateHospedajeRequest $request, Hospedaje $hospedaje)
    {
        Gate::authorize('update', $hospedaje);
        $hospedaje->update($request->validated());
        $hospedaje->servicios()->sync($request->servicios ?? []);

        return redirect()->route('hospedajes.index')
            ->with('success', 'Hospedaje actualizado correctamente.');
    }

    public function destroy(Hospedaje $hospedaje)
    {
        Gate::authorize('delete', $hospedaje);
        $hospedaje->delete();

        return redirect()->route('hospedajes.index')
            ->with('success', 'Hospedaje eliminado correctamente.');
    }
}