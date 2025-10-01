<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryFamilyRequest;
use App\Models\Beneficiary;
use App\Models\BeneficiaryFamily;
use Illuminate\Http\Request;

class BeneficiaryFamilyController extends Controller
{
    public function show($bId, $id)
    {
        $beneficiary = Beneficiary::find($bId);
        if (!$beneficiary) {
            return response()->json(['message' => 'beneficiary not found'], 404);
        }
        $familyMember = $beneficiary->beneficiary_families()->find($id);
        if (!$familyMember) {
            return response()->json(['message' => 'Family member not found for this beneficiary'], 404);
        }

        return response()->json($familyMember, 200);
    }

    public function index($bId)
    {
        $beneficiary = Beneficiary::find($bId);

        if (!$beneficiary) {
            return response()->json(['message' => 'Beneficiary not found'], 404);
        }

        return response()->json($beneficiary->beneficiary_families, 200);
    }


    public function store(StoreBeneficiaryFamilyRequest $request, Beneficiary $beneficiary)
    {
        $beneficiary->beneficiary_families()->create($request->validated());
        return redirect()->route('beneficiary.show', $beneficiary)
            ->with('success', 'تمت إضافة الاحتياج بنجاح ✅');
    }

    public function destroy($bId, $id)
    {
        $beneficiary = Beneficiary::find($bId);
        if (!$beneficiary) {
            return response()->json(['message' => 'beneficiary not found'], 404);
        }
        $familyMember = $beneficiary->beneficiary_families()->find($id);
        if (!$familyMember) {
            return response()->json(['message' => 'family member not found'], 404);
        }
        $familyMember->delete();
        return response()->json(['message' => 'family member deleted successfully'], 200);
    }
}
