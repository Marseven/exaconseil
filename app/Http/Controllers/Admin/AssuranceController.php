<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssuranceController extends Controller
{
    //
    public function index()
    {
        $assurances = Assurance::all();
        return view('admin.assurance.index', compact('assurances'));
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'unique:name'],
            'description' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }

        $assurance = new Assurance();
        $assurance->name = $request->name;
        $assurance->description = $request->description;

        if ($assurance->save()) {
            return back()->with('success', 'Maison d\'assurance créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Assurance $assurance)
    {
        if (isset($_POST['delete'])) {
            if ($assurance->delete()) {
                return back()->with('success', "La maison d'assurance a été supprimé.");
            } else {
                return back()->with('error', "Le assurance n'a pas été supprimé.");
            }
        } else {


            $assurance->name = $request->name;
            $assurance->description = $request->description;

            if ($assurance->save()) {
                return back()->with('success', 'assurance mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
