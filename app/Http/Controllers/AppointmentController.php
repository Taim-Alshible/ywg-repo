<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.list', compact('appointments'));
    }

    public function show($id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json([
                'message' => 'appointment not found'
            ], 404);
        }
        return response()->json($appointment, 200);
    }


    public function store(StoreAppointmentRequest $request)
    {
        // StoreAppointmentRequest يتولى التحقق من صحة جميع البيانات،
        // بما في ذلك patient_id الذي يأتي من الحقل المخفي.
        $validatedData = $request->validated();

        // دمج التاريخ والوقت
        $appointmentDateTime = $validatedData['date'] . ' ' . $validatedData['time'] . ':00';

        // قم بتحديث المصفوفة التي سيتم حفظها
        $validatedData['date'] = $appointmentDateTime;
        $validatedData['is_follow_up'] = $request->has('is_follow_up');

        // إزالة حقل 'time' لأنه أصبح مدمجًا مع 'date'
        unset($validatedData['time']);

        // استخدم الطريقة العامة لإنشاء الموعد
        $appointment = Appointment::create($validatedData);

        // العودة إلى صفحة عرض المريض
        return redirect()->route('patient.show', $appointment->patient_id)
            ->with('success', 'تمت إضافة الموعد بنجاح ✅');
    }
    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json([
                'message' => 'appointment not found'
            ], 404);
        }
        $appointment->update($request->validated());
        return response()->json($appointment, 200);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json([
                'message' => 'appointment not found'
            ], 404);
        }
        $appointment->delete();
        return response()->json(['message' => 'appointment deleted successfully'], 200);
    }
}
