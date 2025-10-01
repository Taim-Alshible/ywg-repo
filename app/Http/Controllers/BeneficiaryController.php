<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\Beneficiary;
use App\Models\Need;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class BeneficiaryController extends Controller
{
    public function index()
    {
        $beneficiaries = Beneficiary::all();
        // return response()->json($beneficiary, 200);
        return view('beneficiary.list', compact('beneficiaries'));
    }

    public function show($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $needsList = Need::all();
        return view('beneficiary.show', [
            'beneficiary' => $beneficiary,
            'needsList' => $needsList
        ]);
    }

    public function create()
    {
        return view('beneficiary.create');
    }
    public function store(StoreBeneficiaryRequest $request)

    {
        $validatedData = $request->validated();
        $beneficiary = Beneficiary::create($validatedData);
        return redirect()->route('beneficiary.list')
            ->with('success', 'Beneficiary created successfully!');
    }

    public function destroy($id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiary->delete();
        return response()->json(null, 204);
    }

    public function update(UpdateBeneficiaryRequest $request, $id)
    {
        $beneficiary = Beneficiary::findOrFail($id);
        $beneficiary->update($request->validated());
        return response()->json($beneficiary, 200);
    }

    public function updateBeneficiaryNeeds(Request $request, $beneficiary_id)
    {
        $beneficiary = Beneficiary::find($beneficiary_id);
        if (!$beneficiary) {
            return response()->json(['message' => 'beneficiary not found'], 404);
        }
        $need = Need::find($request->need_id);
        if (!$need) {
            return response()->json(['message' => 'need not found'], 404);
        }
        $validatedData = $request->validate([
            'need_id' => 'required',
            'need_id.*' => 'exists:needs,id'
        ]);
        $needId = is_array($validatedData['need_id'])
            ? $validatedData['need_id']
            : [$validatedData['need_id']];

        $beneficiary->need()->sync($needId);
        return response()->json([
            'message' => 'beneficiary needs updated successfully'
        ], 200);
    }

    public function getBeneficiaryNeeds($beneficiary_id)
    {
        $beneficiary = Beneficiary::find($beneficiary_id);
        if (!$beneficiary) {
            return response()->json(['message' => 'beneficiary not found'], 404);
        }
        $needs = $beneficiary->need()->get()->map(function ($need) {
            return [
                'id' => $need->id,
                'name' => $need->name,
                'quantity' => $need->pivot->quantity,
                'delivered' => $need->pivot->delivered
            ];
        });
        return response()->json($needs, 200);
    }
    public function user()
    {
        return 'hello world taim';
    }
}
#test line
