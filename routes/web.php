<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


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

// Route::view('/', 'welcome');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); // إذا مسجل دخول يروح للدااشبورد
    }
    return view('home');
})->name('home');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::view('/surveys', 'surveys.index')->name('surveys.index');

    Route::get('/surveys/{survey}/builder', function ($surveyId) {
    $survey = App\Models\Survey::findOrFail($surveyId);
    return view('surveys.builder', ['survey' => $survey]);
    })->name('surveys.builder');

  

    Route::get('/survey/{survey}/analytics', function ($surveyId) {
        $survey = App\Models\Survey::findOrFail($surveyId);
        return view('surveys.analytics', ['survey' => $survey]);
    })->name('surveys.analytics');
});
Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');
// Route::get('/survey/{survey}/fill', function ($surveyId) {
//     $survey = App\Models\Survey::with('questions')->findOrFail($surveyId);
//     return view('surveys.fill', ['survey' => $survey]);
// })->name('surveys.fill');

// أضف ده قبل Route::get('/survey/{survey}/fill'...
Route::middleware('throttle:10,1')->group(function () {
    Route::get('/s/{slug}', function ($slug) {
        $survey = App\Models\Survey::with('questions')->where('slug', $slug)->firstOrFail();
        return view('surveys.fill', compact('survey'));
    })->name('surveys.fill');
});


    
// Route::view('llogin', 'auth.login');
// Route::view('rrr', 'auth.register');
// Route::view('rrr', 'index');
// Route::view('/create-survey', 'create-survey');
// Route::view('/take-survey', 'take-survey');
// require __DIR__.'/auth.php';
