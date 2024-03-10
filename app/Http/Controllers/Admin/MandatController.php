<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MandatExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\Assurance;
use App\Models\Mandat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MandatController extends Controller
{
    //
    public function index()
    {
        $assurances = Assurance::all();
        return view('admin.mandat.index', compact('assurances'));
    }

    public function ajaxList(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $_GET['search'] = $search_arr['value'];

        // Total records
        $totalRecords = Mandat::select('count(*) as allcount')->where('deleted', NULL)->count();
        $totalRecordswithFilter = Mandat::select('count(*) as allcount')
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('mandats.number_mandat', 'like', '%' . $searchValue . '%')
                    ->orWhere('mandats.number_police', 'like', '%' . $searchValue . '%')
                    ->orWhere('mandats.assure', 'like', '%' . $searchValue . '%');
            })->where('deleted', NULL)->count();

        // Fetch records
        $records = Mandat::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('mandats.number_mandat', 'like', '%' . $searchValue . '%')
                    ->orWhere('mandats.number_police', 'like', '%' . $searchValue . '%')
                    ->orWhere('mandats.assure', 'like', '%' . $searchValue . '%');
            })->where('deleted', NULL)
            ->select('mandats.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $user = User::find(Auth::user()->id);
            $user->load(['entreprise']);
            $role = $user->roles->first();

            $record->load(['user']);

            $id = $record->id;

            $number_mandat = $record->number_mandat;
            $assure = $record->assure;
            $tiers = $record->tiers;
            $vehicule = $record->vehicule;
            $immatriculation = $record->immatriculation;

            $_user = "";
            if ($record->user) {
                $_user = $record->user->lastname . ' ' . $record->user->firstname;
            }

            $date_mandat = date_format(date_create($record->date_mandat), 'd-m-Y');

            $actions = '<button style="padding: 10px !important" type="button"
            class="btn btn-primary modal_view_action"
            data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalView' . $record->id . '"><i
                class="bi bi-eye"></i></button>';

            if ($role->hasPermissionTo('edit mandat') && $user->hasService('Mandat') && (Controller::isBefore($record->created_at)  || Auth::user()->roles->first()->name == "Gerant") && ($record->user_id == Auth::user()->id || Auth::user()->roles->first()->name == "Gerant")) {
                $actions .= '
                        <button style="padding: 10px !important" type="button"
                            class="btn btn-secondary modal_edit_action"
                            data-bs-toggle="modal"
                            data-id="' . $record->id . '"
                            data-bs-target="#cardModal' . $record->id . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button style="padding: 10px !important" type="button"
                            class="btn btn-danger modal_delete_action"
                            data-bs-toggle="modal"
                            data-id="' . $record->id . '"
                            data-bs-target="#cardModalCenter' . $record->id . '">
                            <i class="bi bi-trash"></i>
                        </button>';
            }


            $data_arr[] = array(
                "id" => $id,
                "number_mandat" => $number_mandat,
                "assure" => $assure,
                "tiers" => $tiers,
                "vehicule" => $vehicule,
                "immatriculation" => $immatriculation,
                "user" => $_user,
                "actions" => $actions,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return response()->json($response);
    }

    public function ajaxItem(Request $request)
    {
        $mandat = Mandat::with('assurance')->find($request->id);
        $title = "";
        if ($request->action == "view") {
            $mandat->load(['user']);

            $title = "Mandat N°" . $mandat->id;
            $body = '
            <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Maison d\'Assurance</h6>
                <p class="text-uppercase mb-0">' . $mandat->assurance->name . '</p>
            </div>
            <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">N° de Mandat</h6>
                <p class="text-uppercase mb-0">' . $mandat->number_mandat . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">N° de Police
                </h6>
                <p class="mb-0">' . $mandat->number_police . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">N° de Sinistre
                </h6>
                <p class="mb-0">' . $mandat->number_sinistre . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Assuré
                </h6>
                <p class="mb-0">' . $mandat->assure . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Tiers
                </h6>
                <p class="mb-0">' . $mandat->tiers . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Véhicule
                </h6>
                <p class="mb-0">' . $mandat->vehicule . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Immatriculation
                </h6>
                <p class="mb-0">' . $mandat->immatriculation  . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de sinistre
                </h6>
                <p class="mb-0">' . date_format(date_create($mandat->date_sinistre), 'd-m-Y')  . '</p>
            </div>

            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ville
                </h6>
                <p class="mb-0">' . $mandat->place  . '</p>
            </div>
            <div class="col-12 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Circonstances
                </h6>
                <p class="mb-0">' . $mandat->circonstances . ' </p>
            </div>
            <div class="col-12 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Observations
                </h6>
                <p class="mb-0">' . $mandat->observations . ' </p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de mandat
                </h6>
                <p class="mb-0">' . date_format(date_create($mandat->date_mandat), 'd-m-Y') . '</p>
            </div>';
            if ($mandat->mandat_physical) {
                $body .= '<div class="col-6 mb-5">
                    <h6 class="text-uppercase fs-5 ls-2">Pièce Jointe
                    </h6>
                    <p class="mb-0"><a target="_blank" href="' . asset($mandat->mandat_physical) . '"
                    class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">Télécharger
                    <i class="ki-duotone ki-cloud-download">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i></a></p>
                </div>';
            }
            $body .= '<div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ajouté par
                </h6>
                <p class="mb-0">' . ($mandat->user ? $mandat->user->lastname : "-") . ' ' . ($mandat->user ? $mandat->user->firstname : "-") . '</p>
            </div>';
        } elseif ($request->action == "edit") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour le mandat N° : ' . $mandat->number_mandat . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/mandat/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="modal-body">

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Numéro de Mandat</label>
                                <input class="form-control" name="number_mandat" type="text"
                                    placeholder="N° de Mandat" value="' . $mandat->number_mandat . '" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Numéro de Police</label>
                                <input class="form-control" name="number_police" type="text"
                                    placeholder="N° de Police" value="' . $mandat->number_police . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Numéro de Sinistre</label>
                                <input class="form-control" name="number_sinistre" type="text"
                                    placeholder="N° de Sinistre" value="' . $mandat->number_sinistre . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Nom de l\'assuré</label>
                                <input class="form-control" name="assure" type="text"
                                    placeholder="Assurance" value="' . $mandat->assure . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Tiers</label>
                                <input class="form-control" name="tiers" type="text" placeholder="Tiers" value="' . $mandat->tiers . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Véhicule</label>
                                <input class="form-control" name="vehicule" type="text" placeholder="Véhicule" value="' . $mandat->vehicule . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Immatriculation</label>
                                <input class="form-control" name="immatriculation" type="text"
                                    placeholder="Immatriculation" value="' . $mandat->immatriculation . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date de sinistre</label>
                                <input class="form-control" name="date_sinistre" type="date"
                                    placeholder="Date de sinistre" value="' . $mandat->date_sinistre . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Ville</label>
                                <input class="form-control" name="place" type="text" placeholder="Ville" value="' . $mandat->place . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Circonsances</label>
                                <textarea class="form-control" name="circonstances" placeholder="Circonstances et point de choc">' . $mandat->circonstances . '</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Observations</label>
                                <textarea class="form-control" name="observations" placeholder="Observations">v' . $mandat->observations . '</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date du mandat</label>
                                <input class="form-control" name="date_mandat" type="date"
                                    placeholder="Date du mandat" value="' . $mandat->date_mandat . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Pièce Jointe</label>
                                <input class="form-control" name="mandat_physical" type="file" value="' . $mandat->mandat_physical . '" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
            </form>';
        } elseif ($request->action == "status") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour la mandat N° : ' . $mandat->number_mandat . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/mandat/status/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Statut</label>
                                <select class="form-control" name="status" id="_status" onChange="paid_partial()" required>
                                    <option value="paid">Payée</option>
                                    <option value="paid_partially">Payée Partiellement</option>
                                </select>
                            </div>
                        </div>

                        <div id="amount_partiel" class="mb-3" style="display:none;">
                            <div class="input-style-1">
                                <label>Montant</label>
                                <input class="form-control" name="amount" type="number" placeholder="Montant"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
            </form>';
        } else {

            $body = '
            <form method="POST" action="' . url('admin/mandat/' . $request->id) . '">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <input type="hidden" name="delete" value="true">
                <button class="btn btn-danger" type="submit">Supprimer</button>
            </form>';
        }

        $response = array(
            "title" => $title,
            "body" => $body,
        );

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $rules = [
            'number_mandat' => ['required', 'string'],
            'number_police' => ['required', 'string'],
            'number_sinistre' => ['required', 'string'],
            'assure' => ['required', 'string'],
            'tiers' => ['required', 'string'],
            'vehicule' => ['required', 'string'],
            'immatriculation' => ['required', 'string'],
            'date_sinistre' => ['required', 'date'],
            'place' => ['required', 'string'],
            'date_mandat' => ['required', 'date'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }

        $mandat = new Mandat();

        $mandat->number_mandat = $request->number_mandat;
        $mandat->number_police = $request->number_police;
        $mandat->number_sinistre = $request->number_sinistre;
        $mandat->date_sinistre = $request->date_sinistre;
        $mandat->assure =  $request->assure;
        $mandat->tiers =  $request->tiers;
        $mandat->vehicule =  $request->vehicule;
        $mandat->immatriculation =  $request->immatriculation;
        $mandat->place =  $request->place;
        $mandat->date_mandat =  $request->date_mandat;
        $mandat->circonstances = $request->circonstances;
        $mandat->observations = $request->observations;
        $mandat->assurance_id = $request->assurance_id;
        $mandat->user_id = Auth::user()->id;
        $mandat->entreprise_id = Auth::user()->entreprise_id;

        if ($request->file('mandat_physical')) {

            $picture = FileController::piece($request->file('mandat_physical'));
            if ($picture['state'] == false) {
                return back()->withErrors($picture['message']);
            }

            $url = $picture['url'];
            $mandat->mandat_physical =  $url;
        }

        if ($mandat->save()) {
            return back()->with('success', 'mandat créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Mandat $mandat)
    {
        if (isset($_POST['delete'])) {
            $mandat->deleted = 1;
            $mandat->deleted_at = date('Y-m-d H:i:s');
            if ($mandat->save()) {
                return back()->with('success', "La transaction a été supprimé.");
            } else {
                return back()->with('error', "La police n'a pas été supprimé.");
            }
        } else {


            $mandat->number_mandat = $request->number_mandat;
            $mandat->number_police = $request->number_police;
            $mandat->number_sinistre = $request->number_sinistre;
            $mandat->date_sinistre = $request->date_sinistre;
            $mandat->assure =  $request->assure;
            $mandat->tiers =  $request->tiers;
            $mandat->vehicule =  $request->vehicule;
            $mandat->immatriculation =  $request->immatriculation;
            $mandat->place =  $request->place;
            $mandat->date_mandat =  $request->date_mandat;
            $mandat->circonstances = $request->circonstances;
            $mandat->observations = $request->observations;
            $mandat->assurance_id = $request->assurance_id;

            if ($request->file('mandat_physical')) {

                $picture = FileController::piece($request->file('mandat_physical'));
                if ($picture['state'] == false) {
                    return back()->withErrors($picture['message']);
                }

                $url = $picture['url'];
                $mandat->mandat_physical =  $url;
            }

            if ($mandat->save()) {
                return back()->with('success', 'La mandat mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function export(Request $request)
    {
        $day = Carbon::now();
        return Excel::download(new MandatExport($request->begin, $request->end), 'Mandats - ' . $day . '.xlsx');
    }
}
