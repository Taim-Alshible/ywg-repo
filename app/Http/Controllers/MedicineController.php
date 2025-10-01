<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index($patient_id)
    {
        // جلب المريض مع جميع أدويته
        $patient = Patient::with('medicines')->find($patient_id);

        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }

        return view('patients.show', compact('patient'));
    }

    public function show($patient_id, $id)
    {
        $patient = Patient::find($patient_id);

        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }

        // جلب دواء واحد يخص المريض
        $medicine = $patient->medicines()->find($id);

        if (!$medicine) {
            return response()->json(['message' => 'medicine not found'], 404);
        }

        return view('medicines.show', compact('patient', 'medicine'));
    }

    public function store(StoreMedicineRequest $request, Patient $patient)
    {
        $patient->medicines()->create($request->validated());

        return redirect()->route('patient.show', $patient)
            ->with('success', 'تمت إضافة الدواء بنجاح ✅');
    }

    public function toggleDelivered(Medicine $medicine)
    {

        if ($medicine->delivered == 0) {
            $medicine->delivered = !$medicine->delivered;
        }
        $isSaved = $medicine->save();

        if ($isSaved) {
            // إذا نجحت عملية الحفظ، نرجع الحالة الجديدة للحقل 'delivered'
            return response()->json(['delivered' => $medicine->delivered]);
        } else {
            // إذا فشلت عملية الحفظ، نرجع خطأ
            return response()->json(['error' => 'Failed to save the record.'], 500);
        }
    }


    public function destroy($patient_id, $id)
    {
        $patient = Patient::find($patient_id);

        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }

        $medicine = $patient->medicines()->find($id);

        if (!$medicine) {
            return response()->json(['message' => 'medicine not found'], 404);
        }

        $medicine->delete();

        return redirect()->route('patient.show', $patient->id)
            ->with('success', 'تم حذف الدواء بنجاح 🗑️');
    }
}
