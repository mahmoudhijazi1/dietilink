<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class FoodItem extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'food_category_id',
        'name',             // e.g., Chicken breast, Rice
        'default_portion',  // e.g., "100g"
        'calories',
        'notes',
        'unit',
    ];

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }
}
