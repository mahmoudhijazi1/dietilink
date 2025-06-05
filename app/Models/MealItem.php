<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class MealItem extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'meal_id',
        'food_item_id',
        'portion_size',     // e.g., "1 cup", "100g", "1 slice"
        'notes',
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }
}
