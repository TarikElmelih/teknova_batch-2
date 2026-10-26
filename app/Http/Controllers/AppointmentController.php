<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'appointment_number' => 'required|string|max:255',
            'appointment_time' => 'required|date',
            'price' => 'required|numeric',
            'phone_number' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $appointment = Appointment::create($validated);

        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json([
            ...$appointment->toArray(),
            'user' => $appointment->user->name,
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'appointment_number' => 'sometimes|required|string|max:255',
            'appointment_time' => 'sometimes|required|date',
            'price' => 'sometimes|required|numeric',
            'phone_number' => 'sometimes|required|string|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $appointment->update($validated);

        return response()->json($appointment->refresh());
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(null, 204);
    }
}
