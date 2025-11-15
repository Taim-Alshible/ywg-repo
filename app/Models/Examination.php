<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\StaticAnalysisCacheNotConfiguredException;
use Laravel\Scout\Searchable;

class Examination extends Model
{
    use Searchable;
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

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'patient_id' => (string) $this->patient_id,
            'analyses' => $this->analyses,
            'radiologies' => $this->radiologies,
        ];
    }
}
