<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoogleAPIController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\GoogleCalendarController;
use Illuminate\Support\Facades\Route;

use Laravel\Socialite\Facades\Socialite;


use Spatie\GoogleCalendar\Event;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::withoutMiddleware([\App\Http\Middleware\CheckToken::class])->group(function () {
    // Route::get('/test', [GoogleAPIController::class, 'test']);

    Route::get('/', [AccessController::class, 'index'])
        ->name('/');
    Route::post('/login', [AccessController::class, 'login'])
        ->name('login');

    Route::get('/register/{email?}', [RegistrationController::class, 'create'])
        ->name('register.create');

    Route::post('/register', [RegistrationController::class, 'store'])
        ->name('register.store');
    Route::post('/register/{email}', [RegistrationController::class, 'update'])
        ->name('register.update');

    Route::get('/verify/{hash}', [RegistrationController::class, 'edit'])
        ->name('register.edit');
    Route::post('/verify/confirm', [RegistrationController::class, 'confirm'])
        ->name('register.confirm');

});

// Global settings page
Route::get('/settings', [AccessController::class, 'settings'])
    ->name('settings');
Route::post('/logout', [AccessController::class, 'logout'])
    ->name('logout');

Route::resource('categories', CategoryController::class);


// Calendar settings page -> edit route
Route::resource('calendars', CalendarController::class);
Route::resource('helpers', HelperController::class);
Route::resource('activities', ActivityController::class);
Route::resource('targets', TargetController::class);

Route::post('activities/{activity}/publish', [ActivityController::class, 'publish'])
    ->name('activities.publish');
Route::post('targets/upload', [TargetController::class, 'upload'])
    ->name('targets.upload');

// AJAX
Route::post('/calendars/switch', [CalendarController::class, 'switch'])
    ->name('calendars.switch');
Route::post('/calendars/date', [CalendarController::class, 'date'])
    ->name('calendars.date');
    

Route::get('/googleservice', function(){
    $event = new Event;

    $event->name = 'A new event';
    $event->description = 'Event description';
    $event->startDateTime = Carbon\Carbon::now();
    $event->endDateTime = Carbon\Carbon::now()->addHour();
    
    $event->save();

    $events = Event::get();
    var_dump($events);
});


Route::get('/google', [GoogleCalendarController::class, 'getToken']);

Route::post('/publish', [GoogleCalendarController::class, 'publish']);


Route::get('/auth/callback', function () {
    // $googleUser = Socialite::driver('google')->user();
    $googleUser = Socialite::driver('google')->stateless()->user();

    var_dump($googleUser);

    $events = Event::get();

    var_dump($events);
});

Route::get('/redirect', function(){
// return Socialite::driver('google') ->setScopes(['openid', 'email'])
    return Socialite::driver('google') ->setScopes(['openid', 'https://www.googleapis.com/auth/calendar', 'https://www.googleapis.com/auth/calendar.events'])
    ->redirect();
});