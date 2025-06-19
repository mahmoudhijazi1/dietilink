<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Web\Dietitian\AvailabilityController;
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
            // Add this inside the dietitian middleware group in web.php
            Route::prefix('availability')->name('availability.')->group(function () {
                Route::get('/', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'index'])->name('index');
                Route::get('/data', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'getAvailabilityData'])->name('data');
                Route::get('/create', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'store'])->name('store');
                Route::get('/{availabilitySlot}/edit', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'edit'])->name('edit');
                Route::put('/{availabilitySlot}', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'update'])->name('update');
                Route::delete('/{availabilitySlot}', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'destroy'])->name('destroy');
                Route::post('/bulk-store', [App\Http\Controllers\Web\Dietitian\AvailabilityController::class, 'bulkStore'])->name('bulk-store');
            });



            // Appointment Types Routes
            Route::prefix('appointment-types')->name('appointment-types.')->group(function () {
                Route::get('/', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'store'])->name('store');
                Route::get('/{appointmentType}', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'show'])->name('show');
                Route::get('/{appointmentType}/edit', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'edit'])->name('edit');
                Route::put('/{appointmentType}', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'update'])->name('update');
                Route::delete('/{appointmentType}', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'destroy'])->name('destroy');
                Route::post('/update-sort-order', [App\Http\Controllers\Web\Dietitian\AppointmentTypeController::class, 'updateSortOrder'])->name('update-sort-order');
            });

            // Appointments Routes
            Route::prefix('appointments')->name('appointments.')->group(function () {
                Route::get('/', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'index'])->name('index');
                Route::get('/create', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'create'])->name('create');
                Route::post('/', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'store'])->name('store');
                Route::get('/{appointment}', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'show'])->name('show');
                Route::get('/{appointment}/edit', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'edit'])->name('edit');
                Route::put('/{appointment}', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'update'])->name('update');
                Route::delete('/{appointment}', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'destroy'])->name('destroy');

                // Appointment Status Management
                Route::patch('/{appointment}/cancel', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'cancel'])->name('cancel');
                Route::patch('/{appointment}/complete', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'complete'])->name('complete');
                Route::patch('/{appointment}/no-show', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'markNoShow'])->name('no-show');

                // Available Slots API Routes (for AJAX calls)
                Route::get('/available-slots/get', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'getAvailableSlots'])->name('available-slots');
                Route::get('/available-slots/range', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'getAvailableSlotsForRange'])->name('available-slots-range');
                Route::get('/daily-summary/get', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'getDailySummary'])->name('daily-summary');
                Route::get('/next-available/get', [App\Http\Controllers\Web\Dietitian\AppointmentController::class, 'getNextAvailableSlot'])->name('next-available');
            });

            // Calendar Routes
            Route::prefix('calendar')->name('calendar.')->group(function () {
                Route::get('/', [App\Http\Controllers\Web\Dietitian\AppointmentCalendarController::class, 'index'])->name('index');
                Route::get('/data', [App\Http\Controllers\Web\Dietitian\AppointmentCalendarController::class, 'getCalendarData'])->name('data');
            });
        });



    Route::get('/dashboards/crm-analytics', [PagesController::class, 'dashboardsCrmAnalytics'])->name('dashboards/crm-analytics');
});
