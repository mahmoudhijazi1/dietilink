<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Web\Dietitian\DashboardController;
use App\Http\Controllers\Web\Dietitian\FoodController;
use App\Http\Controllers\Web\Dietitian\PatientController;
use App\Http\Controllers\Web\Dietitian\ProgressEntryController;
use App\Http\Controllers\Web\Dietitian\MealPlanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginView'])->name('loginView');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'registerView'])->name('registerView');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
});



Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/', [PagesController::class, 'dashboardsCrmAnalytics'])->name('index');

    Route::get('/api/check-username', [App\Http\Controllers\Web\Dietitian\PatientController::class, 'checkUsername'])
        ->name('api.check-username');


    Route::prefix('dietitian')
        ->middleware(['tenant'])
        ->name('dietitian.')
        ->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // Patient routes
            Route::get('patients/invite', [PatientController::class, 'inviteView'])->name('patients.invite');
            Route::post('patients/invite', [PatientController::class, 'inviteSubmit'])->name('patients.invite.submit');
            Route::post('patients/store', [PatientController::class, 'createWithCredentials'])->name('patients.store');
            Route::get('patients', [PatientController::class, 'index'])->name('patients.index');
            Route::get('patients/create', [PatientController::class, 'create'])->name('patients.create');
            Route::get('patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
            Route::get('patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
            Route::put('patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
            Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

            // New route for sending email (optional)
            Route::post('/patients/invite/email', [PatientController::class, 'sendInviteEmail'])
                ->name('patients.invite.email');

            // Progress Entry routes
            Route::get('patients/{patient}/progress/create', [ProgressEntryController::class, 'create'])->name('progress.create');
            Route::post('patients/{patient}/progress', [ProgressEntryController::class, 'store'])->name('progress.store');
            Route::get('patients/{patient}/progress/{progress}/edit', [ProgressEntryController::class, 'edit'])->name('progress.edit');
            Route::put('patients/{patient}/progress/{progress}', [ProgressEntryController::class, 'update'])->name('progress.update');
            Route::delete('patients/{patient}/progress/{progress}', [ProgressEntryController::class, 'destroy'])->name('progress.destroy');


            // Food Category Routes
            // Food Categories
            Route::get('foods/categories', [FoodController::class, 'indexCategories'])->name('foods.categories.index');
            Route::get('foods/categories/create', [FoodController::class, 'createCategory'])->name('foods.categories.create');
            Route::post('foods/categories', [FoodController::class, 'storeCategory'])->name('foods.categories.store');
            Route::get('foods/categories/{foodCategory}/edit', [FoodController::class, 'editCategory'])->name('foods.categories.edit');
            Route::put('foods/categories/{foodCategory}', [FoodController::class, 'updateCategory'])->name('foods.categories.update');
            Route::delete('foods/categories/{foodCategory}', [FoodController::class, 'destroyCategory'])->name('foods.categories.destroy');

            // Food Items
            Route::get('foods/items', [FoodController::class, 'indexItems'])->name('foods.items.index');
            Route::get('foods/items/create', [FoodController::class, 'createItem'])->name('foods.items.create');
            Route::post('foods/items', [FoodController::class, 'storeItem'])->name('foods.items.store');
            Route::get('foods/items/{foodItem}/edit', [FoodController::class, 'editItem'])->name('foods.items.edit');
            Route::put('foods/items/{foodItem}', [FoodController::class, 'updateItem'])->name('foods.items.update');
            Route::delete('foods/items/{foodItem}', [FoodController::class, 'destroyItem'])->name('foods.items.destroy');

            // Meal Plan routes
            Route::prefix('meal-plans')->name('meal-plans.')->group(function () {
                Route::get('/', [MealPlanController::class, 'index'])->name('index');
                Route::get('/create', [MealPlanController::class, 'create'])->name('create');
                Route::post('/', [MealPlanController::class, 'store'])->name('store');
                Route::get('/{mealPlan}/edit', [MealPlanController::class, 'edit'])->name('edit');
                Route::put('/{mealPlan}', [MealPlanController::class, 'update'])->name('update');
                Route::get('/{mealPlan}', [MealPlanController::class, 'show'])->name('show');
                Route::delete('/{mealPlan}', [MealPlanController::class, 'destroy'])->name('destroy');
                Route::post('/{mealPlan}/activate', [MealPlanController::class, 'activate'])->name('activate');
            }); 
//http://127.0.0.1:9004/dietitian/meal-plans/4/activate
        });



    Route::get('/dashboards/crm-analytics', [PagesController::class, 'dashboardsCrmAnalytics'])->name('dashboards/crm-analytics');
});
