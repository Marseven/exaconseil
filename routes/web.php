<?php

use App\Http\Controllers\Admin\CashflowController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DevisController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\FactureController;
use App\Http\Controllers\Admin\MandatController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SinistreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\WelcomeController;
use App\Mail\PolicyExpirationMail;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
Route::get('/home', [WelcomeController::class, 'index'])->name('home');

Route::get('/test-notification', function () {
    $policy = App\Models\Policy::all()->first();
    Mail::to('mebodoaristide@gmail.com')->send(new PolicyExpirationMail($policy));
    return 'Notification envoyée avec succès !';
});

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
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('admin-notifications');

        Route::get('/settings', [SettingController::class, 'index'])->name('admin-settings');
        Route::post('/save/setting', [SettingController::class, 'save'])->name('admin-save-settings');
        Route::post('/save/notification', [SettingController::class, 'notification'])->name('admin-save-notification');

        //entreprise
        Route::get('/list/entreprises', [EntrepriseController::class, 'index'])->name('admin-list-entreprises');
        Route::post('/create/entreprise', [EntrepriseController::class, 'create'])->name('admin-create-entreprise');
        Route::post('/entreprise/{entreprise}', [EntrepriseController::class, 'update'])->name('admin-update-entreprise');

        //service
        Route::get('/list/services', [ServiceController::class, 'index'])->name('admin-list-services');
        Route::post('/create/service', [ServiceController::class, 'create'])->name('admin-create-service');
        Route::post('/service/{service}', [ServiceController::class, 'update'])->name('admin-update-service');

        //policies
        Route::get('/list/policies', [PolicyController::class, 'index'])->name('admin-list-policies');
        Route::get('/list/policies/expired', [PolicyController::class, 'expired'])->name('admin-list-policies-expired');
        Route::post('/create/policy', [PolicyController::class, 'create'])->name('admin-create-policy');
        Route::post('/policy/{policy}', [PolicyController::class, 'update'])->name('admin-update-policy');
        Route::get('/ajax/policies/{type}', [PolicyController::class, 'ajaxList'])->name('admin-ajax-policies');
        Route::post('/ajax/policy', [PolicyController::class, 'ajaxItem'])->name('admin-ajax-policy');
        Route::post('/export/policy', [PolicyController::class, 'export'])->name('admin-export-policy');
        Route::post('/import/policy', [PolicyController::class, 'import'])->name('admin-import-policy');

        //sinistres
        Route::get('/list/sinistres', [SinistreController::class, 'index'])->name('admin-list-sinistres');
        Route::post('/create/sinistre', [SinistreController::class, 'create'])->name('admin-create-sinistre');
        Route::post('/sinistre/{sinistre}', [SinistreController::class, 'update'])->name('admin-update-sinistre');
        Route::get('/ajax/sinistres', [SinistreController::class, 'ajaxList'])->name('admin-ajax-sinistres');
        Route::post('/ajax/sinistre', [SinistreController::class, 'ajaxItem'])->name('admin-ajax-sinistre');
        Route::post('/export/sinistre', [SinistreController::class, 'export'])->name('admin-export-sinistre');
        Route::post('/import/sinistre', [SinistreController::class, 'import'])->name('admin-import-sinistre');

        //devis
        Route::get('/list/devis', [DevisController::class, 'index'])->name('admin-list-devis');
        Route::post('/create/devis', [DevisController::class, 'create'])->name('admin-create-devis');
        Route::post('/devis/{devis}', [DevisController::class, 'update'])->name('admin-update-devis');
        Route::get('/ajax/devis', [DevisController::class, 'ajaxList'])->name('admin-ajax-devis');
        Route::post('/ajax/devis', [DevisController::class, 'ajaxItem'])->name('admin-ajax-devis');
        Route::post('/export/devis', [DevisController::class, 'export'])->name('admin-export-devis');
        Route::post('/import/devis', [DevisController::class, 'import'])->name('admin-import-devis');

        //mandats
        Route::get('/list/mandats', [MandatController::class, 'index'])->name('admin-list-mandats');
        Route::post('/create/mandat', [MandatController::class, 'create'])->name('admin-create-devis');
        Route::post('/mandat/{mandat}', [MandatController::class, 'update'])->name('admin-update-devis');
        Route::get('/ajax/mandats', [MandatController::class, 'ajaxList'])->name('admin-ajax-mandats');
        Route::post('/ajax/mandat', [MandatController::class, 'ajaxItem'])->name('admin-ajax-mandat');
        Route::post('/export/mandat', [MandatController::class, 'export'])->name('admin-export-mandat');

        //factures
        Route::get('/list/factures', [FactureController::class, 'index'])->name('admin-list-factures');
        Route::get('/list/factures/unpaid', [FactureController::class, 'pending'])->name('admin-list-factures-unpaid');
        Route::get('/ajax/factures/{status}', [FactureController::class, 'ajaxList'])->name('admin-ajax-factures');
        Route::post('/ajax/facture', [FactureController::class, 'ajaxItem'])->name('admin-ajax-facture');
        Route::post('/create/facture', [FactureController::class, 'create'])->name('admin-create-facture');
        Route::post('/facture/{facture}', [FactureController::class, 'update'])->name('admin-update-facture');
        Route::post('/facture/status/{facture}', [FactureController::class, 'statusFacture'])->name('admin-status-facture');

        //cashflows
        Route::get('/list/cashflows', [CashflowController::class, 'index'])->name('admin-list-cashflows');
        Route::get('/add/cashflow', [CashflowController::class, 'add'])->name('admin-add-cashflow');
        Route::get('/edit/cashflow/{cashflow}', [CashflowController::class, 'edit'])->name('admin-edit-cashflow');
        Route::post('/create/cashflow', [CashflowController::class, 'create'])->name('admin-create-cashflow');
        Route::post('/cashflow/{cashflow}', [CashflowController::class, 'update'])->name('admin-update-cashflow');
        Route::get('/ajax/cashflows', [CashflowController::class, 'ajaxList'])->name('admin-ajax-cashflows');
        Route::post('/ajax/cashflow', [CashflowController::class, 'ajaxItem'])->name('admin-ajax-cashflow');
        Route::post('/export/cashflow', [CashflowController::class, 'export'])->name('admin-export-cashflow');

        //cashbox
        Route::get('/list/cashboxs', [CashflowController::class, 'cashbox'])->name('admin-list-cashboxs');
        Route::post('/create/cashbox', [CashflowController::class, 'createCashbox'])->name('admin-create-cashbox');
        Route::post('/cashbox/{cashbox}', [CashflowController::class, 'updateCashbox'])->name('admin-update-cashbox');

        //users
        Route::get('/profil', [UserController::class, 'profil'])->name('admin-profil');
        Route::get('/list/users', [UserController::class, 'index'])->name('admin-list-users');
        Route::get('/list/roles', [UserController::class, 'roles'])->name('admin-list-roles');
        Route::get('/list/permissions', [UserController::class, 'permissions'])->name('admin-list-permissions');
        Route::get('/add/user', [UserController::class, 'add'])->name('admin-add-user');
        Route::get('/edit/user/{user}', [UserController::class, 'edit'])->name('admin-edit-user');
        Route::post('/create/user', [UserController::class, 'create'])->name('admin-create-user');
        Route::post('/user/{user}', [UserController::class, 'update'])->name('admin-update-user');
        Route::post('/create/role', [UserController::class, 'createRole'])->name('admin-create-role');
        Route::post('/role/{role}', [UserController::class, 'updateRole'])->name('admin-update-role');

        Route::post('/select', [UserController::class, 'select'])->name('admin-select');
        Route::post('/select/service', [CashflowController::class, 'select'])->name('admin-select-service');
    });
});
