<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryFamily extends Model
{
    protected $table = 'beneficiary_families';
    protected $guarded = ['id'];

    public function beneficiaries()
    {
        return $this->hasOne(Beneficiary::class);
    }
}
