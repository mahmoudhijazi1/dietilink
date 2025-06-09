<?php

namespace App\Http\Controllers\Web\Dietitian;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Meal;
use App\Models\MealItem;
use App\Models\MealPlan;
use App\Models\Patient;
use DB;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index()
    {
        $mealPlans = MealPlan::with('patient.user')->latest()->paginate(10);
        return view('dietitian.meal_plans.index', compact('mealPlans'));
    }

    public function create()
{
    $patients = Patient::with('user')->get(); // already scoped by tenant
    $foodItems = FoodItem::with('category')->get(); // optional: eager load category for display

    return view('dietitian.meal_plans.create', compact('patients', 'foodItems'));
}

public function show(MealPlan $mealPlan)
{
    // Load the meal plan with its relationships
    $mealPlan->load([
        'patient.user',
        'meals.mealItems.foodItem'
    ]);

    return view('dietitian.meal_plans.show', compact('mealPlan'));
}



public function store(Request $request)
{
    $validated = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'name' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'meals' => 'nullable|array',
        'meals.*.type' => 'required|string|max:255',
        'meals.*.title' => 'nullable|string|max:255',
        'meals.*.description' => 'nullable|string',
        'meals.*.note' => 'nullable|string',
        'meals.*.items' => 'nullable|array',
        'meals.*.items.*.food_item_id' => 'required|exists:food_items,id',
        'meals.*.items.*.portion_size' => 'nullable|string|max:255',
        'meals.*.items.*.notes' => 'nullable|string|max:255',
    ]);

    $validated['tenant_id'] = auth()->user()->tenant_id;

    // Create the meal plan
    $mealPlan = MealPlan::create($validated);

    // Loop through meals
    if (!empty($request->meals)) {
        foreach ($request->meals as $mealData) {
            $meal = new Meal([
                'tenant_id' => auth()->user()->tenant_id,
                'type' => $mealData['type'],
                'title' => $mealData['title'] ?? null,
                'description' => $mealData['description'] ?? null,
                'note' => $mealData['note'] ?? null,
            ]);
            $mealPlan->meals()->save($meal);

            // Loop through items of this meal
            if (!empty($mealData['items'])) {
                foreach ($mealData['items'] as $itemData) {
                    $meal->mealItems()->create([
                        'tenant_id' => auth()->user()->tenant_id,
                        'food_item_id' => $itemData['food_item_id'],
                        'portion_size' => $itemData['portion_size'] ?? null,
                        'notes' => $itemData['notes'] ?? null,
                    ]);
                }
            }
        }
    }

    return redirect()->route('dietitian.meal-plans.edit', $mealPlan->id)
        ->with('success', 'Meal Plan created successfully with meals.');
}


    public function edit(MealPlan $mealPlan)
{
    $patients = Patient::all();
    $foodItems = FoodItem::all();

    $mealData = $mealPlan->meals->map(function ($meal) {
        return [
            'id' => $meal->id,
            'type' => $meal->type,
            'title' => $meal->title,
            'description' => $meal->description,
            'note' => $meal->note,
            'items' => $meal->mealItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'food_item_id' => $item->food_item_id,
                    'portion_size' => $item->portion_size,
                    'notes' => $item->notes,
                ];
            })->values(),
        ];
    });

    return view('dietitian.meal_plans.edit', compact('mealPlan', 'patients', 'foodItems', 'mealData'));
}


    public function update(Request $request, MealPlan $mealPlan)
{
    $validated = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'name' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'meals' => 'nullable|array',
        'meals.*.id' => 'nullable|exists:meals,id',
        'meals.*.type' => 'required|string|max:255',
        'meals.*.title' => 'nullable|string|max:255',
        'meals.*.description' => 'nullable|string',
        'meals.*.note' => 'nullable|string',
        'meals.*.items' => 'nullable|array',
        'meals.*.items.*.id' => 'nullable|exists:meal_items,id',
        'meals.*.items.*.food_item_id' => 'required|exists:food_items,id',
        'meals.*.items.*.portion_size' => 'nullable|string|max:255',
        'meals.*.items.*.notes' => 'nullable|string|max:255',
    ]);

    $mealPlan->update([
        'name' => $validated['name'],
        'notes' => $validated['notes'],
        'patient_id' => $validated['patient_id'],
    ]);

    $existingMealIds = $mealPlan->meals()->pluck('id')->toArray();
    $submittedMealIds = collect($request->meals)->pluck('id')->filter()->toArray();
    $mealsToDelete = array_diff($existingMealIds, $submittedMealIds);
    Meal::destroy($mealsToDelete);

    foreach ($request->meals as $mealData) {
        $meal = isset($mealData['id'])
            ? Meal::find($mealData['id'])
            : new Meal(['tenant_id' => auth()->user()->tenant_id, 'meal_plan_id' => $mealPlan->id]);

        $meal->type = $mealData['type'];
        $meal->title = $mealData['title'] ?? null;
        $meal->description = $mealData['description'] ?? null;
        $meal->note = $mealData['note'] ?? null;
        $meal->save();

        // Handle meal items
        $existingItemIds = $meal->mealItems()->pluck('id')->toArray();
        $submittedItemIds = collect($mealData['items'] ?? [])->pluck('id')->filter()->toArray();
        $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
        MealItem::destroy($itemsToDelete);

        foreach ($mealData['items'] ?? [] as $itemData) {
            $item = isset($itemData['id'])
                ? MealItem::find($itemData['id'])
                : new MealItem(['tenant_id' => auth()->user()->tenant_id, 'meal_id' => $meal->id]);

            $item->food_item_id = $itemData['food_item_id'];
            $item->portion_size = $itemData['portion_size'] ?? null;
            $item->notes = $itemData['notes'] ?? null;
            $item->meal_id = $meal->id;
            $item->save();
        }
    }

    return redirect()->route('dietitian.meal-plans.index')
        ->with('success', 'Meal Plan and meals updated successfully.');
}


    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();

        return redirect()->route('dietitian.meal-plans.index')
            ->with('success', 'Meal Plan deleted.');
    }

    public function activate(MealPlan $mealPlan)
{
    try {
        DB::beginTransaction();
        
        // Set all meal plans for this patient to archived
        MealPlan::where('patient_id', $mealPlan->patient_id)
            ->where('status', 'active')
            ->update(['status' => 'archived']);

        // Activate the selected plan
        $mealPlan->update(['status' => 'active']);

        DB::commit();

        return response()->json(['message' => 'Meal plan activated successfully']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => 'Failed to activate meal plan'], 500);
    }
}
}
