<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class MealPlan extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'patient_id',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
