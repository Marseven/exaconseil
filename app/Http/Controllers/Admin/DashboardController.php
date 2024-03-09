<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use App\Models\Cashflow;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\Mandat;
use App\Models\Policy;
use App\Models\Sinistre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $user->load(['entreprise']);
        $role = $user->roles->first();
        $today = new \DateTime(date('Y-m-d'));
        $today = $today->format('Y-m-d');
        $sign = '<';

        if ($user->entreprise_id == 0) {
            $cashflows = Cashflow::all()->count();
            $factures = Facture::all()->count();
            $cashflows_credit = Cashflow::where('type', 'credit')->get()->count();
            $factures_paid = Facture::where('status', 'paid')->get()->count();
            $policies = Policy::all()->count();
            $policies_exp = Policy::where('date_expired', $sign, $today)->get()->count();
        } else {
            $cashbox = Cashbox::where('entreprise_id', $user->entreprise_id)->get();
            $cashboxs = [];
            foreach ($cashbox as $cash) {
                $cashboxs[] = $cash->id;
            }
            $cashflows = Cashflow::whereIn('cashbox_id', $cashboxs)->get()->count();
            $factures = Facture::where('entreprise_id', $user->entreprise_id)->get()->count();
            $cashflows_credit = Cashflow::whereIn('cashbox_id', $cashboxs)->where('type', 'credit')->get()->count();
            $factures_paid = Facture::where('entreprise_id', $user->entreprise_id)->where('status', 'paid')->get()->count();
            $policies = Policy::where('entreprise_id', $user->entreprise_id)->get()->count();
            $policies_exp = Policy::where('entreprise_id', $user->entreprise_id)->where('date_expired', $sign, $today)->get()->count();
        }

        return view('admin.dashboard.index', compact('cashflows', 'cashflows_credit', 'factures', 'factures_paid', 'policies', 'policies_exp'));
    }

    public function trash()
    {
        if (Auth::user()->roles->first()->name == "Gerant") {
            $cashflows = Cashflow::where('deleted', 1)->get();
            $factures = Facture::where('deleted', 1)->get();
            $devis = Devis::where('deleted', 1)->get();
            $policies = Policy::where('deleted', 1)->get();
            $mandats = Mandat::where('deleted', 1)->get();
            $sinistres = Sinistre::where('deleted', 1)->get();
        } else {
            $cashflows = Cashflow::where('user_id', Auth::user()->id)->where('deleted', 1)->get();
            $factures = Facture::where('user_id', Auth::user()->id)->where('deleted', 1)->get();
            $devis = Devis::where('user_id', Auth::user()->id)->where('deleted', 1)->get();
            $policies = Policy::where('user_id', Auth::user()->id)->where('deleted', 1)->get();
            $mandats = Mandat::where('user_id', Auth::user()->id)->where('deleted', 1)->get();
            $sinistres = Sinistre::where('user_id', Auth::user()->id)->where('deleted', 1)->get();
        }


        return view('admin.dashboard.trash', compact('cashflows', 'factures', 'devis', 'policies', 'mandats', 'sinistres'));
    }

    public function delete($service, $id)
    {
        switch ($service) {
            case "Police":
                $entities = Policy::find($id);
                $entities->delete();
                break;
            case "Facture":
                $entities = Facture::find($id);
                $entities->delete();
                break;
            case "Devis":
                $entities = Devis::find($id);
                $entities->delete();
                break;
            case "Sinistre":
                $entities = Sinistre::find($id);
                $entities->delete();
                break;
            case "Mandat":
                $entities = Mandat::find($id);
                $entities->delete();
                break;
            case "Caisse":
                $entities = Cashflow::find($id);
                $entities->delete();
                break;
            default:
                return back()->with('error', "Aucun élément a été traité.");
                break;
        }

        return back()->with('success', "L'élément a été définitivement supprimé.");
    }

    public function restore($service, $id)
    {
        switch ($service) {
            case "Police":
                $entities = Policy::find($id);
                $entities->deleted = null;
                $entities->save();
                break;
            case "Facture":
                $entities = Facture::find($id);
                $entities->deleted = null;
                $entities->save();
                break;
            case "Devis":
                $entities = Devis::find($id);
                $entities->deleted = null;
                $entities->save();
                break;
            case "Sinistre":
                $entities = Sinistre::find($id);
                $entities->deleted = null;
                $entities->save();
                break;
            case "Mandat":
                $entities = Mandat::find($id);
                $entities->deleted = null;
                $entities->save();
                break;
            case "Caisse":
                $entities = Cashflow::find($id);
                $entities->deleted = null;
                $entities->save();
                break;
            default:
                return back()->with('error', "Aucun élément a été traité.");
                break;
        }

        return back()->with('success', "L'élément a été restauré avec succès.");
    }
}
