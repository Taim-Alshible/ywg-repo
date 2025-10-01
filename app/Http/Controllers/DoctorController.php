<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function create()
    {
        return view('doctor.create');
    }
    public function index()
    {
        $doctors = Doctor::all();
        // return response()->json($doctor, 200);
        return view('doctor.list', compact('doctors'));
    }
    public function show($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }
        return response()->json($doctor, 200);
    }

    public function store(StoreDoctorRequest $request)
    {
        $validatedData = $request->validated();
        $doctor = Doctor::create($validatedData);
        return redirect()->route('doctor.list', $doctor)
            ->with('success', 'تمت إضافة الطبيب بنجاح ✅');
    }
    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }
        $doctor->update($request->validated());
        return response()->json($doctor, 200);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }
        $doctor->delete();
        return response()->json(['message' => 'doctor deleted successfully'], 200);
    }
}
