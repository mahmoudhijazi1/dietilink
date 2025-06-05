<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class FoodCategory extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'name',        // e.g., Carbs, Proteins, Fats, Vegetables
        'description',
        'tenant_id'
    ];

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }
}
