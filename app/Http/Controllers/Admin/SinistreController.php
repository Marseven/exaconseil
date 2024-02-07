<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SinistreController extends Controller
{
    //
    public function index()
    {
        $sinistres = Sinistre::all();
        return view('admin.sinistre.index', compact('sinistres'));
    }

    public function create(Request $request)
    {
        $sinistre = new Sinistre();

        $sinistre->lastname = $request->name;
        $sinistre->firstname = $request->firstname;
        $sinistre->brand = $request->brand;
        $sinistre->matricule = $request->matricule;
        $sinistre->contact = $request->contact;
        $sinistre->assurance = $request->assurance;
        $sinistre->tiers = $request->tiers;
        $sinistre->date_open =  $request->date_open;
        $sinistre->entreprise_id = Auth::user()->entreprise_id;
        $sinistre->user_id = Auth::user()->id;

        if ($sinistre->save()) {
            return back()->with('success', 'Sinistre créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Sinistre $sinistre)
    {
        if (isset($_POST['delete'])) {
            if ($sinistre->delete()) {
                return back()->with('success', "Le sinistre a été supprimé.");
            } else {
                return back()->with('error', "Le sinistre n'a pas été supprimé.");
            }
        } else {

            $sinistre->lastname = $request->name;
            $sinistre->firstname = $request->firstname;
            $sinistre->brand = $request->brand;
            $sinistre->matricule = $request->matricule;
            $sinistre->contact = $request->contact;
            $sinistre->assurance = $request->assurance;
            $sinistre->tiers = $request->tiers;
            $sinistre->date_open =  $request->date_open;

            if ($sinistre->save()) {
                return back()->with('success', 'Sinistre mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
