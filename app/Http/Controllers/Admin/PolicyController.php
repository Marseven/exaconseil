<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    //
    public function index()
    {
        $today = new \DateTime(date('Y-m-d'));
        $today = $today->format('Y-m-d');
        $policies = Policy::where('date_expired', '>', $today)->get();

        return view('admin.policy.index', compact('policies'));
    }

    public function expired()
    {
        $today = new \DateTime(date('Y-m-d'));
        $today = $today->format('Y-m-d');
        $policies = Policy::where('date_expired', '<=', $today)->get();
        return view('admin.policy.expired', compact('policies'));
    }

    public function create(Request $request)
    {
        $policy = new Policy();

        $policy->name = $request->name;
        $policy->brand = $request->brand;
        $policy->matricule = $request->matricule;
        $policy->contact = $request->contact;
        $policy->date_begin =  $request->date_begin;
        $policy->date_expired = $request->date_expired;
        $policy->entreprise_id = Auth::user()->entreprise_id;
        $policy->user_id = Auth::user()->id;

        if ($policy->save()) {
            return back()->with('success', 'police créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Policy $policy)
    {
        if (isset($_POST['delete'])) {
            if ($policy->delete()) {
                return back()->with('success', "La police a été supprimé.");
            } else {
                return back()->with('error', "La police n'a pas été supprimé.");
            }
        } else {

            $policy->name = $request->name;
            $policy->brand = $request->brand;
            $policy->matricule = $request->matricule;
            $policy->contact = $request->contact;
            $policy->date_begin =  $request->date_begin;
            $policy->date_expired = $request->date_expired;

            if ($policy->save()) {
                return back()->with('success', 'Police mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function import(Request $request)
    {
    }

    public function export(Request $request)
    {
    }
}
