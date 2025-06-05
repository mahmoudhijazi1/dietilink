<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    // ==== FOOD CATEGORIES ====

    public function indexCategories()
    {
        $categories = FoodCategory::latest()->paginate(10);
        return view('dietitian.foods.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('dietitian.foods.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        FoodCategory::create($validated);

        return redirect()->route('dietitian.foods.categories.index')
            ->with('success', 'Food category created successfully.');
    }

    public function editCategory(FoodCategory $foodCategory)
    {
        return view('dietitian.foods.categories.edit', compact('foodCategory'));
    }

    public function updateCategory(Request $request, FoodCategory $foodCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $foodCategory->update($validated);

        return redirect()->route('dietitian.foods.categories.index')
            ->with('success', 'Food category updated successfully.');
    }

    public function destroyCategory(FoodCategory $foodCategory)
    {
        $foodCategory->delete();

        return redirect()->route('dietitian.foods.categories.index')
            ->with('success', 'Food category deleted successfully.');
    }

    // ==== FOOD ITEMS ====

    public function indexItems()
    {
        $items = FoodItem::with('category')->latest()->paginate(10);
        return view('dietitian.foods.items.index', compact('items'));
    }

    public function createItem()
    {
        $categories = FoodCategory::all();
        return view('dietitian.foods.items.create', compact('categories'));
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'food_category_id' => 'required|exists:food_categories,id',
            'unit' => 'required|string|max:50',
        ]);

        FoodItem::create($validated);

        return redirect()->route('dietitian.foods.items.index')
            ->with('success', 'Food item created successfully.');
    }

    public function editItem(FoodItem $foodItem)
    {
        $categories = FoodCategory::all();
        return view('dietitian.foods.items.edit', compact('foodItem', 'categories'));
    }

    public function updateItem(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'food_category_id' => 'required|exists:food_categories,id',
            'unit' => 'required|string|max:50',
        ]);



        $foodItem->update($validated);

        return redirect()->route('dietitian.foods.items.index')
            ->with('success', 'Food item updated successfully.');
    }

    public function destroyItem(FoodItem $foodItem)
    {
        $foodItem->delete();

        return redirect()->route('dietitian.foods.items.index')
            ->with('success', 'Food item deleted successfully.');
    }
}
