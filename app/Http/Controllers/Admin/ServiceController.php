<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', compact('services'));
    }

    public function create(Request $request)
    {

        $service = new Service();

        $service->name = $request->name;
        $service->description = $request->description;


        if ($service->save()) {
            return back()->with('success', 'Service créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Service $service)
    {
        if (isset($_POST['delete'])) {
            if ($service->delete()) {
                return back()->with('success', "Le service a été supprimé.");
            } else {
                return back()->with('error', "Le service n'a pas été supprimé.");
            }
        } else {


            $service->name = $request->name;
            $service->description = $request->description;

            if ($service->save()) {
                return back()->with('success', 'Service mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
