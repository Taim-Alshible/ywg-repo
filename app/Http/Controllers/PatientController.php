<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function create()
    {
        return view('patient.create');
    }

    public function index()
    {
        $patients = Patient::all();
        return view('patient.list', compact('patients'));
    }

    public function toggleChecked(Patient $patient)
    {
        $patient->checked = !$patient->checked;
        $patient->save();

        return response()->json(['checked' => (bool) $patient->checked]);
    }

    public function toggleDelivered(Patient $patient)
    {
        $patient->delivered = !$patient->delivered;
        $patient->save();

        return response()->json(['delivered' => (bool) $patient->delivered]);
    }

    public function show(Patient $patient)
    {
        $patient->load('appointments.doctor');
        $doctors = Doctor::all();
        return view('patient.get', [
            'patient' => $patient,
            'doctors' => $doctors,
        ]);
    }

    public function storeAppointment(Request $request, Patient $patient)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $appointment = new Appointment([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->date,
            'appointment_time' => $request->time,
        ]);
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment added successfully!');
    }
    // public function show($id)
    // {
    //     $patient = Patient::find($id);
    //     if (!$patient) {
    //         return view('patient.list');
    //     }
    //     return view('patient.get', compact('patient'));
    // }

    public function store(StorePatientRequest $request)
    {
        $validatedData = $request->validated();
        $patient = Patient::create($validatedData);
        return redirect()->route('patient.show', $patient->id)
            ->with('success', 'Patient created successfully!');
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }

        $patient->update($request->validated());
        return response()->json($patient, 200);
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }

        $patient->delete();
        return redirect()->route('patient.list') // أو 'patients.index' حسب اسم الـ route عندك
            ->with('success', 'Patient deleted successfully.');
    }
}
