<?php

use App\Http\Controllers\Admin\CashflowController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\FactureController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\WelcomeController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('logout',  function () {
    Auth::logout();
    return redirect('home');
});

Route::get('503', function () {
    return 'Accès non autorisé';
});

Route::get('404', function () {
    return 'Page non trouvée';
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/profil');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return redirect('/profil')->with('error', "Vous devez verifier votre email pour accéder à cette page.");
})->middleware('auth')->name('verification.notice');

Route::get('/email/verification-notification', function () {
    $user = User::find(auth()->user()->id);
    $user->sendEmailVerificationNotification();

    return back()->with('success', 'Le lien de vérification a été envoyé. Consultez votre boîte mail (les spams également) pour valider votre email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware('auth')->group(function () {
    /*
    | Backend
    */
    Route::prefix('admin')->namespace('Admin')->middleware('admin')->group(function () {

        //dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/notifications', [DashboardController::class, 'notifications']);

        //entreprise
        Route::get('/list/entreprises', [EntrepriseController::class, 'index'])->name('admin-list-entreprises');
        Route::get('/add/entreprise', [EntrepriseController::class, 'add'])->name('admin-add-entreprise');
        Route::get('/edit/entreprise/{entreprise}', [EntrepriseController::class, 'edit'])->name('admin-edit-entreprise');
        Route::post('/create/entreprise', [EntrepriseController::class, 'create'])->name('admin-create-entreprise');
        Route::post('/entreprise/{entreprise}', [EntrepriseController::class, 'update'])->name('admin-update-entreprise');

        //policies
        Route::get('/list/policies', [PolicyController::class, 'index'])->name('admin-list-policies');
        Route::get('/add/policy', [PolicyController::class, 'add'])->name('admin-add-policy');
        Route::get('/edit/policy/{policy}', [PolicyController::class, 'edit'])->name('admin-edit-policy');
        Route::post('/create/policy', [PolicyController::class, 'create'])->name('admin-create-policy');
        Route::post('/policy/{policy}', [PolicyController::class, 'update'])->name('admin-update-policy');

        //factures
        Route::get('/list/factures', [FactureController::class, 'index'])->name('admin-list-factures');
        Route::get('/add/facture', [FactureController::class, 'add'])->name('admin-add-facture');
        Route::get('/edit/policy/{policy}', [FactureController::class, 'edit'])->name('admin-edit-facture');
        Route::post('/create/policy', [FactureController::class, 'create'])->name('admin-create-facture');
        Route::post('/policy/{policy}', [FactureController::class, 'update'])->name('admin-update-facture');

        //cashflows
        Route::get('/list/cashflows', [CashflowController::class, 'index'])->name('admin-list-cashflows');
        Route::get('/add/cashflow', [CashflowController::class, 'add'])->name('admin-add-cashflow');
        Route::get('/edit/cashflow/{cashflow}', [CashflowController::class, 'edit'])->name('admin-edit-cashflow');
        Route::post('/create/cashflow', [CashflowController::class, 'create'])->name('admin-create-cashflow');
        Route::post('/cashflow/{cashflow}', [CashflowController::class, 'update'])->name('admin-update-cashflow');

        //users
        Route::get('/profil', [UserController::class, 'profil'])->name('admin-profil');
        Route::get('/list/users', [UserController::class, 'index'])->name('admin-list-users');
        Route::get('/list/roles', [UserController::class, 'roles'])->name('admin-list-roles');
        Route::get('/list/permissions', [UserController::class, 'permissions'])->name('admin-list-permissions');
        Route::get('/add/user', [UserController::class, 'add'])->name('admin-add-user');
        Route::get('/edit/user/{user}', [UserController::class, 'edit'])->name('admin-edit-user');
        Route::post('/create/user', [UserController::class, 'create'])->name('admin-create-user');
        Route::post('/user/{user}', [UserController::class, 'update'])->name('admin-update-user');
    });
});
