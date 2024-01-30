<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use App\Models\Cashflow;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    //
    public function index()
    {
        $cashflows = Cashflow::all();
        $cashboxes = Cashbox::where('entreprise_id', Auth::user()->entreprise_id)->get();
        return view('admin.cashflow.index', compact('cashflows', 'cashboxes'));
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

    public function create(Request $request)
    {
        $cashflow = new Cashflow();

        $cashflow->type = $request->type;
        $cashflow->reason = $request->reason;
        $cashflow->amount = $request->amount;
        $cashflow->date_cash = $request->date_cash;
        $cashflow->cashbox_id =  $request->cashbox_id;
        $cashflow->user_id = Auth::user()->id;

        if ($cashflow->save()) {
            return back()->with('success', 'Transaction créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Cashflow $cashflow)
    {
        if (isset($_POST['delete'])) {
            if ($cashflow->delete()) {
                return back()->with('success', "La transaction a été supprimé.");
            } else {
                return back()->with('error', "La police n'a pas été supprimé.");
            }
        } else {

            $cashflow->type = $request->type;
            $cashflow->reason = $request->reason;
            $cashflow->amount = $request->amount;
            $cashflow->date_cash = $request->date_cash;

            if ($cashflow->save()) {
                return back()->with('success', 'La transaction mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
