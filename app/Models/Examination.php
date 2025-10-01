<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\StaticAnalysisCacheNotConfiguredException;

class Examination extends Model
{
    protected $table = 'examinations';
    protected $guarded = ['id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function analyses()
    {
        return $this->hasMany(Analysis::class, 'examination_id');
    }

    public function radiologies()
    {
        return $this->hasMany(Radiology::class, 'examination_id');
    }
}
