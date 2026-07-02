<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Routing\Attributes\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

#[Middleware('auth')]
#[Middleware('permission:crear reserva', only: ['create', 'store'])]
#[Middleware('permission:editar reserva', only: ['edit', 'update'])]
class ReservaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservas = $user->hasRole('admin') || $user->hasRole('recepcionista')
            ? Reserva::with(['user', 'habitacion.hospedaje'])->latest()->paginate(10)
            : Reserva::where('user_id', $user->id)
                ->with(['habitacion.hospedaje'])
                ->latest()->paginate(10);

        return view('reservas.index', compact('reservas'));
    }

    public function create()
    {
        $habitaciones = Habitacion::where('estado', 'disponible')->with('hospedaje')->get();
        return view('reservas.create', compact('habitaciones'));
    }

    public function store(StoreReservaRequest $request)
    {
        Reserva::create([
            'user_id' => Auth::id(),
            'habitacion_id' => $request->habitacion_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    public function show(Reserva $reserva)
    {
        Gate::authorize('view', $reserva);
        $reserva->load('habitacion.hospedaje', 'user');
        return view('reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        Gate::authorize('update', $reserva);
        $habitaciones = Habitacion::where('estado', 'disponible')->with('hospedaje')->get();
        return view('reservas.edit', compact('reserva', 'habitaciones'));
    }

    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        Gate::authorize('update', $reserva);
        $reserva->update($request->validated());

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Reserva $reserva)
    {
        Gate::authorize('cancel', $reserva);
        $reserva->update(['estado' => 'cancelada']);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva cancelada correctamente.');
    }
}