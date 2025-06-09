<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Meal extends Model
{
    use BelongsToTenant;

    protected $fillable = [
    'tenant_id',
    'meal_plan_id',
    'type',
    'title',
    'description',
    'note',
    'order',
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
