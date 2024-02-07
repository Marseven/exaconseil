<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevisController extends Controller
{
    //

    public function index()
    {
        $devis = Devis::all();

        return view('admin.devis.index', compact('devis'));
    }

    public function create(Request $request)
    {
        $devis = new Devis();

        $devis->name = $request->name;
        $devis->brand = $request->brand;
        $devis->matricule = $request->matricule;
        $devis->contact = $request->contact;
        $devis->number_chassis =  $request->number_chassis;
        $devis->entreprise_id = Auth::user()->entreprise_id;
        $devis->user_id = Auth::user()->id;

        if ($devis->save()) {
            return back()->with('success', 'devis créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, devis $devis)
    {
        if (isset($_POST['delete'])) {
            if ($devis->delete()) {
                return back()->with('success', "Le debis a été supprimé.");
            } else {
                return back()->with('error', "Le devis n'a pas été supprimé.");
            }
        } else {

            $devis->name = $request->name;
            $devis->brand = $request->brand;
            $devis->matricule = $request->matricule;
            $devis->contact = $request->contact;
            $devis->number_chassis =  $request->number_chassis;

            if ($devis->save()) {
                return back()->with('success', 'Devis mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
