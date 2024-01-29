<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    //
    public function index()
    {
        $entreprises = Entreprise::all();
        return view('admin.entreprise.index', compact('entreprises'));
    }

    public function create(Request $request)
    {
        $url = null;

        if ($request->file('logo')) {
            $picture = FileController::nominee($request->file('logo'));
            if ($picture['state'] == false) {
                return back()->withErrors($picture['message']);
            }

            $url = $picture['url'];
        }

        $entreprise = new Entreprise();

        $entreprise->company_name = $request->company_name;
        $entreprise->business_sector = $request->business_sector;
        $entreprise->email = $request->email;
        $entreprise->phone = $request->phone;
        $entreprise->photo = $url;
        $entreprise->address = $request->address;


        if ($entreprise->save()) {
            return back()->with('success', 'Entreprise créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Entreprise $entreprise)
    {
        if (isset($_POST['delete'])) {
            if ($entreprise->delete()) {
                return back()->with('success', "Le rôle a été supprimé.");
            } else {
                return back()->with('error', "Le rôle n'a pas été supprimé.");
            }
        } else {
            $url = $entreprise->photo;

            if ($request->file('logo')) {
                $picture = FileController::nominee($request->file('logo'));
                if ($picture['state'] == false) {
                    return back()->withErrors($picture['message']);
                }

                $url = $picture['url'];
            }

            $entreprise->company_name = $request->company_name;
            $entreprise->business_sector = $request->business_sector;
            $entreprise->email = $request->email;
            $entreprise->phone = $request->phone;
            $entreprise->photo = $url;
            $entreprise->address = $request->address;

            if ($entreprise->save()) {
                return back()->with('success', 'Entreprise mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
