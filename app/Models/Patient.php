<?php

// app/Models/Patient.php

namespace App\Models;

use App\Models\Traits\BelongsToTenantThroughUser;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use BelongsToTenantThroughUser;
    protected $fillable = [
        'user_id', 'height', 'initial_weight', 'goal_weight', 'activity_level',
        'medical_conditions', 'allergies', 'dietary_preferences', 'notes', 'additional_info','phone','gender'
    ];

    protected $casts = [
        'additional_info' => 'array', // for json column
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
