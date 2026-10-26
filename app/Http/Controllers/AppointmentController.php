<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Appointment::create($request->all());


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'appointment_number' => 'required|string|max:255',
            'appointment_time' => 'required|date',
            'price' => 'required|numeric',
            'phone_number' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            
        ]);

        Appointment::create($validated);
        $appointments = Appointment::latest()->first();
        return response()->json($appointments, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment = Appointment::find(1);
        $user = $appointment->user->name;

        return response()->json([ 
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'appointment_number' => 'required|string|max:255',
            'appointment_time' => 'required|date',
            'price' => 'required|numeric',
            'phone_number' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
