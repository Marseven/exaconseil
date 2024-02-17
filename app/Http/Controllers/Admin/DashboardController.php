<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use App\Models\Cashflow;
use App\Models\Facture;
use App\Models\Policy;
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
}
