<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExaminationRequest;
use App\Http\Requests\UpdateExaminationRequest;
use App\Models\Examination;
use App\Models\Patient;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{

    public function create(Patient $patient)
    {

        return view('examination.create', ['patient' => $patient]);
    }
   public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        $examinations = $searchTerm
            ? Examination::search($searchTerm)->get()
            : Examination::all();

        return view('examination.list', [
            'examinations' => $examinations,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function search(Request $request)
    {
        if (!$request->filled('search')) {
            return redirect()->route('examination.list');
        }

        return $this->index($request);
    }

    public function exportPdf(Request $request)
    {
        $searchTerm = $request->query('search');

        $examinations = $searchTerm
            ? Examination::search($searchTerm)->get()
            : Examination::all();

        $examinations->load(['patient', 'analyses', 'radiologies']);

        $generatedAt = now();

        $arabic = new Arabic('Glyphs');

        $pdf = Pdf::loadView('examination.pdf', [
            'examinations' => $examinations,
            'searchTerm' => $searchTerm,
            'generatedAt' => $generatedAt,
            'arabic' => $arabic,
        ])->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('examinations-' . $generatedAt->format('Ymd_His') . '.pdf');
    }

    public function show($id)
    {
        $examination = Examination::findOrFail($id);
        if (!$examination) {
            return  response()->json(['message' => 'examination not found'], 404);
        }

        return view('examination.show', ['examination' => $examination]);
    }

    public function store(StoreExaminationRequest $request, Patient $patient)
    {
        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('myPhoto', 'public');
            $validated['image'] = $path;
        }
         $patient->examination()->create($validated);
        return redirect()->route('patient.show', $patient)
            ->with('success', 'تمت إضافةالفحص بنجاح ✅');
    }

    public function update(UpdateExaminationRequest $request, $patient_id, $id)
    {
        $patient = Patient::find($patient_id);
        if (!$patient) {
            return response()->json(['message' => 'patient not found'], 404);
        }
        $examination = $patient->examination()->find($id);
        if (!$examination) {
            return  response()->json(['message' => 'examination not found'], 404);
        }
        $examination->update($request->validated());
        return response()->json($examination, 200);
    }

    public function destroy($id)
    {
        $examination = Examination::findOrFail($id);
        $examination->delete();
        return redirect()->route('examination.list')
            ->with('success', 'examination deleted successfully.');
    }
}
