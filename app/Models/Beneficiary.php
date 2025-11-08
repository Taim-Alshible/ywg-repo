<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
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
}
