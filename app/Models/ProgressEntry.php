<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('tenant_filter', function ($query) {
            $user = Auth::user();
            if ($user && $user->tenant_id && $user->role !== 'super_admin') {
                $query->whereHas('patient.user', function ($q) use ($user) {
                    $q->where('tenant_id', $user->tenant_id);
                });
            }
        });
    }
}
