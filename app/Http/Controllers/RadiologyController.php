<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRadiologyRequest;
use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Http\Request;

class RadiologyController extends Controller
{
    public function store(StoreRadiologyRequest $request, Examination $examination)
    {
        $validated = $request->validated();
        if ($request->hasFile('radiology_file')) {
            $path = $request->file('radiology_file')->store('myFile', 'public');
            $validated['radiology_file'] = $path;
        }
        $examination->radiologies()->create($validated);
        return redirect()->route('examination.show', $examination)
            ->with('success', 'تم اضافة صورة الأشعة بنجاح✅');
    }
}
