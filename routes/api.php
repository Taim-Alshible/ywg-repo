 <?php

    use App\Http\Controllers\AppointmentController;
    use App\Http\Controllers\BeneficiaryController;
    use App\Http\Controllers\BeneficiaryFamilyController;
    use App\Http\Controllers\DoctorController;
    use App\Http\Controllers\DoctorVacancyController;
    use App\Http\Controllers\ExaminationController;
    use App\Http\Controllers\MedicineController;
    use App\Http\Controllers\NeedController;
    use App\Http\Controllers\PatientController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::patch('/medicine/{medicine}/toggle-delivered', [MedicineController::class, 'toggleDelivered'])->name('api.medicine.toggle-delivered');
    Route::patch('/beneficiary/{beneficiary}/need/{need}/toggle-delivered', [BeneficiaryController::class, 'toggleDelivered'])
        ->name('api.need.toggle-delivered');
    Route::patch('/beneficiary/{beneficiary}/toggle-checked', [BeneficiaryController::class, 'toggleChecked'])
        ->name('api.beneficiary.toggle-checked');
    Route::patch('/beneficiary/{beneficiary}/toggle-delivered-status', [BeneficiaryController::class, 'toggleDeliveredStatus'])
        ->name('api.beneficiary.toggle-delivered');

    Route::patch('/patient/{patient}/toggle-checked', [PatientController::class, 'toggleChecked'])
        ->name('api.patient.toggle-checked');
    Route::patch('/patient/{patient}/toggle-delivered', [PatientController::class, 'toggleDelivered'])
        ->name('api.patient.toggle-delivered');
