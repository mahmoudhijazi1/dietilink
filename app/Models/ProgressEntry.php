<?php
// app/Models/ProgressEntry.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressEntry extends Model
{
    protected $fillable = [
        'patient_id',
        'weight',
        'measurements',
        'notes',
        'measurement_date',
    ];

    protected $casts = [
        'measurements' => 'array',
        'measurement_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
