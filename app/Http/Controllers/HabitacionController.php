<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHabitacionRequest;
use App\Http\Requests\UpdateHabitacionRequest;
use App\Models\Habitacion;
use App\Models\Hospedaje;
use Illuminate\Routing\Attributes\Middleware;
use Illuminate\Support\Facades\Gate;

#[Middleware('auth')]
#[Middleware('permission:ver habitacion', only: ['index', 'show'])]
#[Middleware('permission:crear habitacion', only: ['create', 'store'])]
#[Middleware('permission:editar habitacion', only: ['edit', 'update'])]
#[Middleware('permission:eliminar habitacion', only: ['destroy'])]
class HabitacionController extends Controller
{
    public function index(Hospedaje $hospedaje)
    {
        Gate::authorize('view', $hospedaje);
        $habitaciones = $hospedaje->habitaciones()->latest()->paginate(10);
        return view('habitaciones.index', compact('hospedaje', 'habitaciones'));
    }

    public function create(Hospedaje $hospedaje)
    {
        Gate::authorize('update', $hospedaje);
        return view('habitaciones.create', compact('hospedaje'));
    }

    public function store(StoreHabitacionRequest $request, Hospedaje $hospedaje)
    {
        Gate::authorize('update', $hospedaje);
        $hospedaje->habitaciones()->create($request->validated());

        return redirect()->route('hospedajes.habitaciones.index', $hospedaje)
            ->with('success', 'Habitación creada correctamente.');
    }

    public function show(Hospedaje $hospedaje, Habitacion $habitacion)
    {
        return view('habitaciones.show', compact('hospedaje', 'habitacion'));
    }

    public function edit(Hospedaje $hospedaje, Habitacion $habitacion)
    {
        Gate::authorize('update', $habitacion);
        return view('habitaciones.edit', compact('hospedaje', 'habitacion'));
    }

    public function update(UpdateHabitacionRequest $request, Hospedaje $hospedaje, Habitacion $habitacion)
    {
        Gate::authorize('update', $habitacion);
        $habitacion->update($request->validated());

        return redirect()->route('hospedajes.habitaciones.index', $hospedaje)
            ->with('success', 'Habitación actualizada correctamente.');
    }

    public function destroy(Hospedaje $hospedaje, Habitacion $habitacion)
    {
        Gate::authorize('delete', $habitacion);
        $habitacion->delete();

        return redirect()->route('hospedajes.habitaciones.index', $hospedaje)
            ->with('success', 'Habitación eliminada correctamente.');
    }
}