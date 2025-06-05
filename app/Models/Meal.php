<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Meal extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'meal_plan_id',
        'type',        // e.g., breakfast, lunch, dinner
        'title',       // e.g., Option 1, Option 2
        'description',
        'note',
    ];

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function mealItems()
    {
        return $this->hasMany(MealItem::class);
    }
}
