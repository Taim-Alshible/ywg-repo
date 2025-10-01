<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $guarded = ['id'];

    // العلاقة الصحيحة: الموعد ينتمي إلى طبيب واحد
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // العلاقة الصحيحة: الموعد ينتمي إلى مريض واحد
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
