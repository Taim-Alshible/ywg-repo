<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNeedRequest;
use App\Http\Requests\UpdateNeedRequest;
use App\Models\Beneficiary;
use App\Models\Need;
use Illuminate\Http\Request;

class NeedController extends Controller
{
    public function index()
    {
        $need = Need::all();
        return response()->json($need, 200);
    }
    public function show($id)
    {
        $need = Need::find($id);
        if (!$need) {
            return response()->json(['message' => 'need not found'], 404);
        }
        return response()->json($need, 200);
    }
    public function store(StoreNeedRequest $request)
    {
        $validatedData = $request->validated();
        $need = Need::create($validatedData);
        return response()->json($need, 201);
    }
    public function update(UpdateNeedRequest $request, $id)
    {
        $need = Need::find($id);
        if (!$need) {
            return response()->json(['message' => 'need not found'], 404);
        }
        $need->update($request->validated());
        return response()->json($need, 200);
    }
    public function destroy($id)
    {
        $need = Need::find($id);
        if (!$need) {
            return response()->json(['message' => 'need not found'], 404);
        }
        $need->delete();
        return response()->json(['message' => 'need deleted successfully'], 200);
    }
}
