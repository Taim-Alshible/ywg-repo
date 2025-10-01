<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalysisRequest;
use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function store(StoreAnalysisRequest $request, Examination $examination)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('myFile', 'public');
            $validated['file'] = $path;
        }
        $examination->analyses()->create($validated);
        return redirect()->route('examination.show', $examination)
            ->with('success', 'تم اضافة التحليل بنجاح✅');
    }

    // public function index($examination_id)
    // {
    //     $patient = Patient::with('analyses')->find($patient_id);
    //     return view('examination.show', ['patient' => $patient]);
    // }
}
