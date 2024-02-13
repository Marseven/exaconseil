<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Service;
use App\Models\ServiceEntreprise;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        $entreprises = Entreprise::all();
        $entreprises->load(['services']);
        $services = Service::all();
        $settings = Setting::all();
        return view('admin.setting.index', compact('entreprises', 'services', 'settings'));
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

    public function notification(Request $request)
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            $sg = Setting::where('key', $setting->key)->first();
            if ($sg) {
                $sg->value = $request->input($setting->key);
                $sg->save();
            }
        }

        return back()->with('success', 'Paramètres enregistrés.');
    }
}
