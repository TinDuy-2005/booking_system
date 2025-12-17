<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class CustomerAppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['service', 'staff'])
            ->where('user_id', auth()->id())
            ->get();

        return view('booking.my_appointments', compact('appointments'));
    }
}
