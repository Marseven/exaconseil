<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\Assurance;
use App\Models\Facture;
use App\Models\Mandat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FactureController extends Controller
{
    //
    public function index()
    {
        $mandats = Mandat::with('facture')->get();
        $assurances = Assurance::all();
        return view('admin.facture.index', compact('mandats', 'assurances'));
    }

    public function pending()
    {
        $mandats = Mandat::with('facture')->get();
        $assurances = Assurance::all();
        return view('admin.facture.pending', compact('mandats', 'assurances'));
    }

    public function ajaxList(Request $request, $status)
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
        $totalRecords = Facture::select('count(*) as allcount')->where('deleted', NULL)->count();
        $totalRecordswithFilter = Facture::select('count(*) as allcount')
            ->where('status', $status)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('factures.number_facture', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.type_prestation', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.amount', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.assurance_id', $searchValue);
            })->where('deleted', NULL)->count();

        // Fetch records
        $records = Facture::orderBy($columnName, $columnSortOrder)
            ->where('status', $status)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('factures.number_facture', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.type_prestation', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.amount', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.assurance_id',  $searchValue);
            })->where('deleted', NULL)
            ->select('factures.*')
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

            $number_facture = $record->number_facture;
            $assurance = $record->assurance_id == null ? "-" : $record->assurance_id;
            $courtier = $record->company_assurance ?? '-';
            $type_prestation = $record->type_prestation;
            $amount = Controller::format_amount($record->amount) . ' FCFA';

            $_status = Controller::status($record->status);

            $_status = '<span class="badge py-3 px-4 fs-7 badge-light-' . $_status['type'] . '">' . $_status['message'] . '</span>';

            $_user = "";
            if ($record->user) {
                $_user = $record->user->lastname . ' ' . $record->user->firstname;
            }

            $date_facture = date_format(date_create($record->date_facture), 'd-m-Y');

            $actions = '<button style="padding: 10px !important" type="button"
            class="btn btn-primary modal_view_action"
            data-id="' . $record->id . '"><i
                class="bi bi-eye"></i></button>';

            // if ($record->status != 'paid') {
            //     $actions .= '<button style="padding: 10px !important; margin-left:4px;" type="button"
            //             class="btn btn-info modal_status_action"
            //             data-id="' . $record->id . '">
            //             <i class="bi bi-currency-exchange"></i>
            //         </button> ';
            // }

            if ($role->hasPermissionTo('edit facture') && $user->hasService('Facture') && (Controller::isBefore($record->created_at)  || Auth::user()->roles->first()->name == "Gerant") && ($record->user_id == Auth::user()->id || Auth::user()->roles->first()->name == "Gerant")) {
                $actions .= '
                        <button style="padding: 10px !important" type="button"
                            class="btn btn-secondary modal_edit_action"
                            data-id="' . $record->id . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button style="padding: 10px !important" type="button"
                            class="btn btn-danger modal_delete_action"
                            data-id="' . $record->id . '">
                            <i class="bi bi-trash"></i>
                        </button>';
            }


            $data_arr[] = array(
                "id" => $id,
                "assurance" => $assurance,
                "number_facture" => $number_facture,
                "courtier" => $courtier,
                "type_prestation" => $type_prestation,
                "amount" => $amount,
                "user" => $_user,
                "date_facture" => $date_facture,
                "status" => $_status,
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
        $facture = Facture::with('assurance')->find($request->id);
        $title = "";
        if ($request->action == "view") {
            $facture->load(['user', 'mandat']);
            $status = Controller::status($facture->status);

            $title = "Facture N°" . $facture->id;
            $body = '
            <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Maison d\'Assurance</h6>
                <p class="text-uppercase mb-0">' . $facture->assurance->name . '</p>
            </div>
            <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Numéro de facture</h6>
                <p class="text-uppercase mb-0">' . $facture->number_facture . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Courtier d\'assurance</h6>
                <p class="mb-0">' . $facture->company_assurance . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Assuré
                </h6>
                <p class="mb-0">' . $facture->assure . ' XAF</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Tiers
                </h6>
                <p class="mb-0">' . $facture->tiers . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Véhicule
                </h6>
                <p class="mb-0">' . $facture->vehicule . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Immatriculation
                </h6>
                <p class="mb-0">' . $facture->immatriculation  . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Référence Sinistre
                </h6>
                <p class="mb-0">' . $facture->ref_sinistre . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de sinistre
                </h6>
                <p class="mb-0">' . date_format(date_create($facture->date_sinistre), 'd-m-Y')  . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de mission
                </h6>
                <p class="mb-0">' . date_format(date_create($facture->date_mission), 'd-m-Y')  . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ville
                </h6>
                <p class="mb-0">' . $facture->place  . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Montant de la facture
                </h6>
                <p class="mb-0">' . Controller::format_amount($facture->amount) . ' FCFA</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de facture
                </h6>
                <p class="mb-0">' . date_format(date_create($facture->date_facture), 'd-m-Y') . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Statut
                </h6>
                <p class="mb-0">
                    <span class="badge badge-' . $status['type'] . '">' . $status['message'] . '</span>
                </p>
            </div>';

            if ($facture->facture_physical) {
                $body .= '<div class="col-6 mb-5">
                    <h6 class="text-uppercase fs-5 ls-2">Pièce Jointe
                    </h6>
                    <p class="mb-0"><a target="_blank" href="' . asset($facture->facture_physical) . '"
                    class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">Télécharger
                    <i class="ki-duotone ki-cloud-download">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i></a></p>
                </div>';
            }

            if ($facture->mandat_id != null) {
                $body .= '<div class="col-6 mb-5">
                    <h6 class="text-uppercase fs-5 ls-2">Mandat
                    </h6>
                    <p class="mb-0">' . $facture->mandat->number_mandat . '</p>
                </div>';
            }

            $body .= '<div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ajouté par
                </h6>
                <p class="mb-0">' . ($facture->user ? $facture->user->lastname : "-") . ' ' . ($facture->user ? $facture->user->firstname : "-") . '</p>
            </div>';
        } elseif ($request->action == "edit") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour la facture N° : ' . $facture->number_facture . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/facture/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Numéro de facture</label>
                                <input class="form-control" name="number_facture" type="text"
                                    placeholder="N° de facture" value="' . $facture->number_facture . '" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Courtier d\'assurance</label>
                                <input class="form-control" name="company_assurance" type="text"
                                    placeholder="Assurance" value="' . $facture->company_assurance . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Assuré</label>
                                <input class="form-control" name="assure" type="text" placeholder="Assuré" value="' . $facture->assure . '" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Tiers</label>
                                <input class="form-control" name="tiers" type="text" placeholder="Tiers" value="' . $facture->tiers . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Véhicule</label>
                                <input class="form-control" name="vehicule" type="text" placeholder="Véhicule" value="' . $facture->vehicule . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Immatriculation</label>
                                <input class="form-control" name="immatriculation" type="text"
                                    placeholder="Immatriculation" value="' . $facture->immatriculation . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Référence sinistre</label>
                                <input class="form-control" value="' . $facture->ref_sinistre . '" name="ref_sinistre" type="text" placeholder="Référence" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date de sinistre</label>
                                <input class="form-control" name="date_sinistre" type="date"
                                    placeholder="Date de facture" value="' . $facture->date_sinistre . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date de mission</label>
                                <input class="form-control" name="date_mission" type="date"
                                    placeholder="Date de mission" value="' . $facture->date_mission . '" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Ville</label>
                                <input class="form-control" name="place" value="' . $facture->place . '" type="text" placeholder="Ville" required/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Type de prestation</label>
                                <select class="form-control" name="type_prestation" required>
                                    <option value="Standard">Standard</option>
                                    <option value="Particulier">Particulier</option>
                                    <option value="Intérieur">Intérieur</option>
                                    <option value="Flotte">Flotte</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Montant</label>
                                <input class="form-control" value="' . $facture->amount . '" name="amount" type="number" placeholder="Montant"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date de la facture</label>
                                <input class="form-control" name="date_facture" type="date"
                                    placeholder="Date de facture" value="' . $facture->date_facture . '" required />
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
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour la facture N° : ' . $facture->number_facture . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/facture/status/' . $request->id) . '" method="POST">
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
            <form method="POST" action="' . url('admin/facture/' . $request->id) . '">
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
            'number_facture' => ['required', 'string'],
            'assure' => ['required', 'string'],
            'vehicule' => ['required', 'string'],
            'immatriculation' => ['required', 'string'],
            'place' => ['required', 'string'],
            'type_prestation' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'date_facture' => ['required', 'date'],
        ];

        if ($request->assurance_id != null) {
            $rules[] = ['assurance_id' => ['exists:assurances,name']];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }

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
        $facture->assurance_id =  $request->assurance_id;

        if ($request->mandat_id != 0) {
            $facture->mandat_id =  $request->mandat_id;
        }

        if ($request->file('facture_physical')) {
            $picture = FileController::piece($request->file('facture_physical'));
            if ($picture['state'] == false) {
                return back()->withErrors($picture['message']);
            }
            $url = $picture['url'];
            $facture->facture_physical =  $url;
        }

        if ($facture->save()) {
            return back()->with('success', 'Facture créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Facture $facture)
    {
        if (isset($_POST['delete'])) {
            $facture->deleted = 1;
            $facture->deleted_at = date('Y-m-d H:i:s');
            if ($facture->save()) {
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

            if ($request->mandat_id) {
                $facture->mandat_id =  $request->mandat_id;
            }

            if ($request->file('facture_physical')) {

                $picture = FileController::piece($request->file('facture_physical'));
                if ($picture['state'] == false) {
                    return back()->withErrors($picture['message']);
                }

                $url = $picture['url'];
                $facture->facture_physical =  $url;
            }

            if ($facture->save()) {
                return back()->with('success', 'La facture mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function statusFacture(Request $request, Facture $facture)
    {

        $facture->status =  $request->status;

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
            return redirect('admin/list/factures')->with('success', 'La facture mis à jour avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }
}
