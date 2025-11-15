<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Beneficiary extends Model
{
    use Searchable;
    protected $table = 'beneficiaries';
    protected $guarded = ['id'];

    public function beneficiary_families()
    {
        return $this->hasMany(BeneficiaryFamily::class, 'beneficiary_id');
    }

    public function needs()
    {
        return $this->belongsToMany(Need::class, 'beneficiary_need')
            ->withPivot('quantity', 'priority', 'delivered')
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
            'checked' => (bool) $this->checked,
            'delivered' => (bool) $this->delivered,
            'created_at' => $this->created_at->timestamp,

        ];
    }
}
