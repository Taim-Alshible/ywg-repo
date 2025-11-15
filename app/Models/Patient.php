<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Patient extends Model
{
    use Searchable;
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

     public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'fName' => $this->fName,
            'father_name' => $this->father_name,
            'lName' => $this->lName,
            'phone' => $this->phone,
            'nationalNum' => $this->nationalNum,
            'location' => $this->location,
            'needDoctor' => (bool) $this->needDoctor,
            'specialty' => $this->specialty,
            'created_at' => $this->created_at->timestamp,

        ];
    }

   
}
