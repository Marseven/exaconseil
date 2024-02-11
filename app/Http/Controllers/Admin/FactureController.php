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
        return view('admin.facture.index');
    }

    public function pending()
    {
        return view('admin.facture.pending');
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
        $totalRecords = Facture::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Facture::select('count(*) as allcount')
            ->where('status', $status)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('factures.number_facture', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.type_prestation', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.amount', 'like', '%' . $searchValue . '%');
            })->count();

        // Fetch records
        $records = Facture::orderBy($columnName, $columnSortOrder)
            ->where('status', $status)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('factures.number_facture', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.type_prestation', 'like', '%' . $searchValue . '%')
                    ->orWhere('factures.amount', 'like', '%' . $searchValue . '%');
            })
            ->select('factures.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $record->load(['user']);

            $id = $record->id;

            $number_facture = $record->name;
            $type_prestation = $record->brand;
            $amount = $record->matricule;
            $_status = $record->status;
            $user = $record->user->lastname . ' ' . $record->user->firstname;
            $date_facture = date_format(date_create($record->date_begin), 'd-m-Y');

            $actions = '<button style="padding: 10px !important" type="button"
            class="btn btn-primary modal_view_action"
            data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalView' . $record->id . '"><i
                class="bi bi-eye"></i></button> ';




            if (Auth::user()->id) {
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
                "number_facture" => $number_facture,
                "type_prestation" => $type_prestation,
                "amount" => $amount,
                "user" => $user,
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
        $facture = Facture::find($request->id);
        $title = "";
        if ($request->action == "view") {
            $facture->load(['user']);

            $title = "Facture N°" . $facture->id;
            $body = ' <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Numéro de facture</h6>
                <p class="text-uppercase mb-0">' . $facture->number_facture . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Compagnie Assurance </h6>
                <p class="mb-0">' . $facture->company_assurance ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Assuré
                </h6>
                <p class="mb-0">' . $facture->assure ?? '-' . ' XAF</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Tiers
                </h6>
                <p class="mb-0">' . $facture->tiers ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Véhicule
                </h6>
                <p class="mb-0">' . $facture->vehicule ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Immatriculation
                </h6>
                <p class="mb-0">' . $facture->immatricualtion ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Référence Sinistre
                </h6>
                <p class="mb-0">' . $facture->ref_sinsitre ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de sinistre
                </h6>
                <p class="mb-0">' . date_format(date_create($facture->date_sinistre), 'd-m-Y') ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de mission
                </h6>
                <p class="mb-0">' . date_format(date_create($facture->date_mission), 'd-m-Y') ?? '-' . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ville
                </h6>
                <p class="mb-0">' . $facture->place ?? '-' . '</p>
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
                <h6 class="text-uppercase fs-5 ls-2">Ajouté par
                </h6>
                <p class="mb-0">' . $facture->user->lastname . ' ' . $facture->user->firstname . '</p>
            </div>';

            $body .= '</div>';
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
                                <label>Numéro de facture</label>
                                <input class="form-control" name="number_facture" type="text"
                                    placeholder="N° de facture" value="' . $facture->number_facture . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Compagnie d\'assurance</label>
                                <input class="form-control" name="company_assurance" type="text"
                                    placeholder="Assurance" value="' . $facture->company_assurance . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Assuré</label>
                                <input class="form-control" name="assure" type="text" placeholder="Assuré" value="' . $facture->assure . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Tiers</label>
                                <input class="form-control" name="tiers" type="text" placeholder="Tiers" value="' . $facture->tiers . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Véhicule</label>
                                <input class="form-control" name="vehicule" type="text" placeholder="Véhicule" value="' . $facture->vehicule . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Immatriculation</label>
                                <input class="form-control" name="immatriculation" type="text"
                                    placeholder="Immatriculation" value="' . $facture->immatriculation . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Référence sinistre</label>
                                <input class="form-control" value="' . $facture->ref_sinistre . '" name="ref_sinistre" type="text" placeholder="Référence" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de sinistre</label>
                                <input class="form-control" name="date_sinistre" type="date"
                                    placeholder="Date de facture" value="' . $facture->date_sinistre . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de mission</label>
                                <input class="form-control" name="date_mission" type="date"
                                    placeholder="Date de mission" value="' . $facture->date_mission . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Ville</label>
                                <input class="form-control" name="place" value="' . $facture->place . '" type="text" placeholder="Ville" />
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
                                <label>Montant</label>
                                <input class="form-control" value="' . $facture->amount . '" name="amount" type="number" placeholder="Montant"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de la facture</label>
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
