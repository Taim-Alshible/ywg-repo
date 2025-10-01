<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radiology extends Model
{
    protected $table = 'radiologies';
    protected $guarded = ['id'];

    public function examination()
    {
        return $this->belongsTo(examination::class);
    }
}
