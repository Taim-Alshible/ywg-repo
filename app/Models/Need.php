<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    protected $table = 'needs';
    protected $guarded = ['id'];

    public function beneficiary()
    {
        return $this->belongsToMany(Beneficiary::class);
    }
}
