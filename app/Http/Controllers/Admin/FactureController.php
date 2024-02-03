<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    //
    public function index()
    {
        $factures = Facture::all();
        $factures->load(['user']);
        return view('admin.facture.index', compact('factures'));
    }

    public function pending()
    {
        $factures = Facture::all();
        $factures->load(['user']);
        return view('admin.facture.index', compact('factures'));
    }

    public function create(Request $request)
    {
        $facture = new Facture();

        $facture->number_facture = $request->number_facture;
        $facture->company_assurance = $request->company_assurance;
        $facture->date_sinistre = $request->date_sinistre;
        $facture->date_mission = $request->date_mission;
        $facture->ref_sinistre =  $request->ref_sinistre;
        $facture->assure =  $request->assure;
        $facture->tiers =  $request->tiers;
        $facture->vehicule =  $request->vehicule;
        $facture->immatriculation =  $request->immatriculation;
        $facture->place =  $request->place;
        $facture->type_prestation =  $request->type_prestation;
        $facture->amount =  $request->amount;
        $facture->date_facture =  $request->date_facture;
        $facture->status =  'unpaid';
        $facture->user_id = Auth::user()->id;
        $facture->entreprise_id = Auth::user()->entreprise_id;

        if ($facture->save()) {
            return back()->with('success', 'Facture créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Facture $facture)
    {
        if (isset($_POST['delete'])) {
            if ($facture->delete()) {
                return back()->with('success', "La transaction a été supprimé.");
            } else {
                return back()->with('error', "La police n'a pas été supprimé.");
            }
        } else {

            $facture->number_facture = $request->number_facture;
            $facture->company_assurance = $request->company_assurance;
            $facture->date_sinistre = $request->date_sinistre;
            $facture->date_mission = $request->date_mission;
            $facture->ref_sinistre =  $request->ref_sinistre;
            $facture->assure =  $request->assure;
            $facture->tiers =  $request->tiers;
            $facture->vehicule =  $request->vehicule;
            $facture->immatriculation =  $request->immatriculation;
            $facture->place =  $request->place;
            $facture->type_prestation =  $request->type_prestation;
            $facture->amount =  $request->amount;
            $facture->date_facture =  $request->date_facture;

            if ($facture->save()) {
                return back()->with('success', 'La facture mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function status(Request $request, Facture $facture)
    {

        $facture->status =  $request->company_assurance;

        if ($facture->status == 'paid_partially') {
            $facture->amount_paid += $request->amount_paid;
            $facture->amount_rest = $facture->amout - $request->amount_paid;
        } else {
            $facture->amount_paid = $facture->amount;
            $facture->amount_rest = 0;
        }

        if ($facture->amount < $facture->amount_paid) back()->with('error', 'La montant payé est supérieur au montant de la facture.');

        $facture->date_paid =  $request->date_paid;

        if ($facture->save()) {
            return back()->with('success', 'La facture mis à jour avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }
}
