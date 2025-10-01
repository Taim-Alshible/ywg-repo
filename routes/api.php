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
