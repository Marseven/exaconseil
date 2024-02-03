<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Service;
use App\Models\ServiceEntreprise;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        $entreprises = Entreprise::all();
        $entreprises->load(['services']);
        $services = Service::all();
        return view('admin.setting.index', compact('entreprises', 'services'));
    }

    public function save(Request $request)
    {
        ServiceEntreprise::where('entreprise_id', $request->entreprise_id)->delete();

        foreach ($request->services as $service) {
            $service_ent = new ServiceEntreprise();
            $service_ent->entreprise_id = $request->entreprise_id;
            $service_ent->service_id = $service;
            $service_ent->save();
        }

        return back()->with('success', 'Paramètres enregistrés.');
    }
}
