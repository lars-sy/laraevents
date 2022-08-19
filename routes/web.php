<?php


use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\Auth\{
    RegisterController,
    LoginController
};
use App\Http\Controllers\Participant\Dashboard\DashboardController as ParticipantDashboardController;
use App\Http\Controllers\Organization\{
    Dashboard\DashboardController as OrganizationDashboardController,
    Event\EventController,
    Event\EventPresenceController
};
use App\Http\Controllers\Organization\Event\EventSubscriptionController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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

Route::group(['as' => 'auth.'], function(){ //prefixo auth no name da rota
    Route::group([ 'middleware' => 'guest'], function(){
        Route::get('register', [RegisterController::class, 'create'])->name('register.create');
        Route::post('register', [RegisterController::class, 'store'])->name('register.store');
        Route::get('login', [LoginController::class, 'create'])->name('login.create');
        Route::post('login', [LoginController::class, 'store'])->name('login.store');
    });

    Route::post('logout', [LoginController::class, 'destroy'])->name('login.destroy')->middleware('auth'); //middleware auth, somente users autenticados
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('participant/dashboard', [ParticipantDashboardController::class, 'index'])->name('participant.dashboard.index')->middleware('role:participant');
   
    Route::group(['prefix' => 'organization', 'as' => 'organization.', 'middleware' => 'role:organization'], function(){
       //dashboard
        Route::get('dashboard', [OrganizationDashboardController::class, 'index'])->name('dashboard.index');

        /*
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
  
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
       */
        //eventos
        Route::post('events/{event}/subscription', [EventSubscriptionController::class, 'store'])->name('events.subscription.store');
        Route::delete('events/{event}/subscription/{user}', [EventSubscriptionController::class, 'destroy'])->name('events.subscription.destroy');
        Route::post('events/{event}/presences/{user}', EventPresenceController::class)->name('events.presences');
        Route::resource('events', EventController::class);

    });
});

