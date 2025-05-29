<?php

// app/Models/Dietitian.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dietitian extends Model
{
    protected $fillable = [
        'user_id', 'clinic_name', 'phone', 'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
