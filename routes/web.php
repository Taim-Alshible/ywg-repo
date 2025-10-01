<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiaryFamilyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorVacancyController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RadiologyController;
use App\Models\Beneficiary;
use App\Models\Examination;
use App\Models\Radiology;
use Illuminate\Support\Facades\Route;

Route::get('beneficiary/create', [BeneficiaryController::class, 'create'])->name('beneficiary.create');
Route::get('beneficiary', [BeneficiaryController::class, 'index'])->name('beneficiary.list');
Route::get('beneficiary/{id}', [BeneficiaryController::class, 'show'])->name('beneficiary.show');
Route::post('beneficiary', [BeneficiaryController::class, 'store'])->name('beneficiary.store');
Route::put('beneficiary/{id}', [BeneficiaryController::class, 'update']);
Route::delete('beneficiary/{id}', [BeneficiaryController::class, 'destroy'])->name('beneficiary.destroy');

Route::post('beneficiary/{beneficiary}/family', [BeneficiaryFamilyController::class, 'store'])->name('family.store');
// Route::apiResource('beneficiary', BeneficiaryController::class);
Route::post('beneficiary/{beneficiary_id}/need', [BeneficiaryController::class, 'addNeedToBeneficiary']);
Route::put('beneficiary/{beneficiary_id}/need', [BeneficiaryController::class, 'updateBeneficiaryNeeds']);
Route::get('beneficiary/{beneficiary_id}/need', [BeneficiaryController::class, 'getBeneficiaryNeeds']);
Route::apiResource('beneficiary/{bId}/family', BeneficiaryFamilyController::class);

// Route::post('')

Route::get('medicine/{patient_id}/create', [MedicineController::class, 'create'])->name('medicine.create');
Route::get('medicine/{patient_id}', [MedicineController::class, 'index'])->name('medicine.list');
Route::get('medicine/{patient_id}/{id}', [MedicineController::class, 'show']);
Route::post('/patient/{patient}/medicines', [MedicineController::class, 'store'])->name('medicine.store');
// Route::patch('/medicine/{medicine}/toggle-delivered', [MedicineController::class, 'toggleDelivered'])->name('medicine.toggle-delivered');
Route::delete('medicine/{patient_id}/{id}', [MedicineController::class, 'destroy']);

// Route::apiResource('doctor', DoctorController::class);

Route::get('doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
Route::get('doctor', [DoctorController::class, 'index'])->name('doctor.list');
Route::post('doctor', [DoctorController::class, 'store'])->name('doctor.store');
Route::apiResource('doctor/{doctor_id}/vacancy', DoctorVacancyController::class);

// Route::apiResource('patient', PatientController::class);
Route::get('patient/create', [PatientController::class, 'create'])->name('patient.create');
Route::get('patient', [PatientController::class, 'index'])->name('patient.list');
// Route::get('patient/{id}', [PatientController::class, 'show'])->name('patient.show');
Route::get('/patient/{patient}', [PatientController::class, 'show'])->name('patient.show');

Route::delete('patient/{id}', [PatientController::class, 'destroy'])->name('patient.destroy');
Route::post('/patient/{patient}/appointment', [PatientController::class, 'storeAppointment'])->name('appointment.store');

Route::post('patient', [PatientController::class, 'store'])->name('patient.store');




Route::post('/patient/{patient}/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');

Route::get('/patients/{patient}/examination/create', [ExaminationController::class, 'create'])
    ->name('examination.create');
Route::post('patients/{patient}/examination', [ExaminationController::class, 'store'])->name('examination.store');
Route::get('examination', [ExaminationController::class, 'index'])->name('examination.list');
Route::get('examination/{examination_id}', [ExaminationController::class, 'show'])->name('examination.show');
Route::delete('examination/{examination_id}', [ExaminationController::class, 'destroy'])->name('examination.destroy');

Route::post('examination/{examination}/analysis', [AnalysisController::class, 'store'])->name('analysis.store');

Route::post('examination/{examination}/radiology', [RadiologyController::class, 'store'])->name('radiology.store');

