<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    // Save patient data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Patient::create($request->all());

        return back()->with('success', 'Patient data has been submitted successfully!');
    }

    // Show list in admin
    public function index()
    {
        $patients = Patient::orderBy('id', 'asc')->paginate(10); // or ->get() if not paginating
        return view('patient_console.list', compact('patients'));
    }
}