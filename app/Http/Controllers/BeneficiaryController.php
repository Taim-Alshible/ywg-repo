<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryNeedRequest;
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

    public function toggleChecked(Beneficiary $beneficiary)
    {
        $beneficiary->checked = !$beneficiary->checked;
        $beneficiary->save();

        return response()->json(['checked' => (bool) $beneficiary->checked]);
    }

    public function toggleDeliveredStatus(Beneficiary $beneficiary)
    {
        $beneficiary->delivered = !$beneficiary->delivered;
        $beneficiary->save();

        return response()->json(['delivered' => (bool) $beneficiary->delivered]);
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

    public function addNeedToBeneficiary(StoreBeneficiaryNeedRequest $request, $beneficiary_id)
    {
        // The $request->validated() *should* ideally contain need_id, quantity, and delivered.
        // If it doesn't, ensure they are present.
        $validatedData = $request->validated();

        // Use $request->input('need_id') only if it's not present in $validatedData
        $needId = $validatedData['need_id'] ?? $request->input('need_id');

        // Find the Beneficiary model instance
        $beneficiary = Beneficiary::findOrFail($beneficiary_id);

        // Get the data for the pivot table (quantity, delivered)
        $pivotData = array_intersect_key(
            $validatedData,
            array_flip(['quantity', 'priority', 'delivered']) // Keys in the pivot table besides the foreign keys
        );

        // Use the relationship method needs() and call attach()
        // The first argument is the ID of the model to attach (Need ID)
        // The second argument is an array of data for the pivot table
        $beneficiary->needs()->attach($needId, $pivotData);

        return redirect()->route('beneficiary.show', ['id' => $beneficiary_id]);
    }

    public function toggleDelivered(Beneficiary $beneficiary, Need $need)
    {
        $beneficiaryNeed = $beneficiary->needs()
            ->where('needs.id', $need->id)
            ->first();

        if (!$beneficiaryNeed) {
            return response()->json(['error' => 'Need not associated with beneficiary'], 404);
        }

        $newDeliveredStatus = !$beneficiaryNeed->pivot->delivered;

        $beneficiary->needs()->updateExistingPivot($need->id, [
            'delivered' => $newDeliveredStatus,
        ]);
        
        return response()->json(['delivered' => (bool) $newDeliveredStatus]);
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
