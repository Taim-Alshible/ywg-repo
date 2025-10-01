<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorVacancyRequest;
use App\Http\Requests\UpdateDoctorVacancyRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorVacancyController extends Controller
{
    public function index($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }
        return response()->json($doctor->vacancy, 200);
    }

    public function show($doctor_id, $id)
    {
        $doctor = Doctor::find($doctor_id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }

        $vacancy = $doctor->vacancy()->find($id);
        if (!$vacancy) {
            return response()->json(['message' => 'doctor vacancy not found'], 404);
        }
        return response()->json($vacancy, 200);
    }

    public function store(StoreDoctorVacancyRequest $request, $doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }

        $doctorVacancy = $doctor->vacancy()->create($request->validated());
        return response()->json($doctorVacancy, 200);
    }

    public function update(UpdateDoctorVacancyRequest $request, $doctor_id, $id)
    {
        $doctor = Doctor::find($doctor_id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }

        $doctorVacancy = $doctor->vacancy()->find($id);
        if (!$doctorVacancy) {
            return response()->json(['message' => 'doctor vacancy not found'], 404);
        }
        $doctorVacancy->update($request->validated());
        return response()->json($doctorVacancy, 200);
    }
    public function destroy($doctor_id, $id)
    {
        $doctor = Doctor::find($doctor_id);
        if (!$doctor) {
            return response()->json(['message' => 'doctor not found'], 404);
        }

        $vacancy = $doctor->vacancy()->find($id);
        if (!$vacancy) {
            return response()->json(['message' => 'doctor vacancy not found'], 404);
        }

        $vacancy->delete();
        return response()->json(['message' => 'doctor vacancy deleted successfully'], 200);
    }
}
