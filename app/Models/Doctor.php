<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $guarded = ['id'];

    public function vacancy()
    {
        return $this->hasMany(DoctorVacancy::class, 'doctor_id');
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
    
    public function patient()
    {
        return $this->belongsToMany(Patient::class, 'appointments')
            ->withPivot('date')
            ->withTimestamps();
    }
}
