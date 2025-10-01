<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorVacancy extends Model
{
    protected $table = 'doctor_vacancies';
    protected $guarded = ['id'];

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}
