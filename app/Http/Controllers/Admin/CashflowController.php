<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    //
    public function index()
    {
        return view('admin.cashflow.index');
    }

    public function cashbox()
    {
        $cashboxs = Cashbox::all();
        $entreprises = Entreprise::all();
        $cashboxs->load(['entreprise']);
        return view('admin.cashflow.cashbox', compact('cashboxs', 'entreprises'));
    }

    public function createCashbox(Request $request)
    {

        $cashbox = new Cashbox();

        $cashbox->solde = $request->solde;
        $cashbox->user_id = Auth::user()->id;
        $cashbox->entreprise_id = $request->entreprise_id;


        if ($cashbox->save()) {
            return back()->with('success', 'Caisse créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function updateCashbox(Request $request, Cashbox $cashbox)
    {
        if (isset($_POST['delete'])) {
            if ($cashbox->delete()) {
                return back()->with('success', "Le rôle a été supprimé.");
            } else {
                return back()->with('error', "Le rôle n'a pas été supprimé.");
            }
        } else {


            $cashbox->solde = $request->solde;

            if ($cashbox->save()) {
                return back()->with('success', 'Caisse mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
