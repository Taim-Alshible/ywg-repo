<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $guarded = ['id'];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'patient_id');
    }

    public function examination()
    {
        return $this->hasMany(Examination::class, 'patient_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsToMany(Doctor::class, 'appointments')
            ->withPivot('date')
            ->withTimestamps();
    }

   
}
