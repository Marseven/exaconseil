<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SinistresExport;
use App\Http\Controllers\Controller;
use App\Imports\SinistresImport;
use App\Models\Sinistre;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SinistreController extends Controller
{
    //
    public function index()
    {
        $sinistres = Sinistre::all();
        return view('admin.sinistre.index', compact('sinistres'));
    }

    public function ajaxList(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->load(['entreprise']);
        $role = $user->roles->first();

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
        $totalRecords = Sinistre::select('count(*) as allcount')->where('deleted', NULL)->count();
        $totalRecordswithFilter = Sinistre::select('count(*) as allcount')
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('sinistres.lastname', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.firstname', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.assurance', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.brand', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.matricule', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.contact', 'like', '%' . $searchValue . '%');
            })->where('deleted', NULL)->count();

        // Fetch records
        $records = Sinistre::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('sinistres.lastname', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.firstname', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.assurance', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.brand', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.matricule', 'like', '%' . $searchValue . '%')
                    ->orWhere('sinistres.contact', 'like', '%' . $searchValue . '%');
            })->where('deleted', NULL)
            ->select('sinistres.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $record->load(['user']);

            $id = $record->id;

            $lastname = $record->lastname . ' ' . $record->firstname;
            $tiers = $record->tiers;
            $assurance = $record->assurance;
            $brand = $record->brand;
            $matricule = $record->matricule;
            $contact = $record->contact;
            $date_open = date_format(date_create($record->date_open), 'd-m-Y');

            $_status = Controller::status($record->status);
            $_status = '<span class="badge py-3 px-4 fs-7 badge-light-' . $_status['type'] . '">' . $_status['message'] . '</span>';

            $actions = '<button style="padding: 10px !important" type="button"
            class="btn btn-primary modal_view_action"
            data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalView' . $record->id . '"><i
                class="bi bi-eye"></i></button> ';

            if ($role->hasPermissionTo('edit sinistre') && $user->hasService("Sinistre") && (Controller::isBefore($record->created_at)  || Auth::user()->roles->first()->name == "Gerant") && ($record->user_id == Auth::user()->id || Auth::user()->roles->first()->name == "Gerant")) {
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
                "lastname" => $lastname,
                "brand" => $brand,
                "matricule" => $matricule,
                "contact" => $contact,
                "date_open" => $date_open,
                "assurance" => $assurance,
                "tiers" => $tiers,
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
        $sinistre = Sinistre::find($request->id);
        $title = "";
        if ($request->action == "view") {
            $sinistre->load(['user']);

            $title = "Police d'assurance N°" . $sinistre->id;
            $body = ' <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Nom Complet</h6>
                <p class="text-uppercase mb-0">' . $sinistre->lastname . ' ' . $sinistre->firstname . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Marque </h6>
                <p class="mb-0">' . $sinistre->brand . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Matricule
                </h6>
                <p class="mb-0">' . $sinistre->matricule . ' XAF</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Contact
                </h6>
                <p class="mb-0">' . $sinistre->contact . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Assurance
                </h6>
                <p class="mb-0">' . $sinistre->assurance . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Tiers
                </h6>
                <p class="mb-0">' . $sinistre->tiers . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Contact
                </h6>
                <p class="mb-0">' . $sinistre->contact . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date d\'ouverture
                </h6>
                <p class="mb-0">' . date_format(date_create($sinistre->date_open), 'd-m-Y') . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ajouté par
                </h6>
                <p class="mb-0">' . $sinistre->user->lastname . ' ' . $sinistre->user->firstname . '</p>
            </div>';

            $body .= '</div>';
        } elseif ($request->action == "edit") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour le sinistre N° : ' . $sinistre->id . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/sinistre/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Nom</label>
                                    <input class="form-control" name="lastname" type="text" placeholder="Nom"
                                        value="' . $sinistre->lastname . '" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label">Prénom</label>
                                    <input class="form-control" name="firstname" type="text" placeholder="Prénom"
                                        value="' . $sinistre->firstname . '" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Marque / Type</label>
                                    <input class="form-control" name="brand" type="text" placeholder="Marque"
                                        value="' . $sinistre->brand . '" required />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Immatriculation</label>
                                    <input class="form-control" name="matricule" type="text" placeholder="Matricule"
                                        value="' . $sinistre->matricule . '" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Contact</label>
                                    <input class="form-control" name="contact" type="tel" placeholder="Contact"
                                        value="' . $sinistre->contact . '" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Assurance</label>
                                    <input class="form-control" name="assurance" type="text" placeholder="Assurance"
                                        value="' . $sinistre->assurance . '" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Tiers</label>
                                    <input class="form-control" name="tiers" type="text" placeholder="Tiers"
                                        value="' . $sinistre->tiers . '" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label class="form-label required">Date d\'ouverture</label>
                                    <input class="form-control" name="date_open" type="date"
                                        placeholder="Date d\'ouverture" value="' . $sinistre->date_open . '" required />
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
            <form method="POST" action="' . url('admin/sinistre/' . $request->id) . '">
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
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'matricule' => ['required', 'string'],
            'contact' => ['required', 'string'],
            'date_open' => ['required', 'date'],
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'assurance' => ['required', 'string'],
            'tiers' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }

        $sinistre = new Sinistre();

        $sinistre->lastname = $request->lastname;
        $sinistre->firstname = $request->firstname;
        $sinistre->brand = $request->brand;
        $sinistre->matricule = $request->matricule;
        $sinistre->contact = $request->contact;
        $sinistre->assurance = $request->assurance;
        $sinistre->tiers = $request->tiers;
        $sinistre->date_open =  $request->date_open;
        $sinistre->status =  'unpaid';
        $sinistre->entreprise_id = Auth::user()->entreprise_id;
        $sinistre->user_id = Auth::user()->id;

        if ($sinistre->save()) {
            return back()->with('success', 'Sinistre créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Sinistre $sinistre)
    {
        if (isset($_POST['delete'])) {
            $sinistre->deleted = 1;
            $sinistre->deleted_at = date('Y-m-d H:i:s');
            if ($sinistre->save()) {
                return back()->with('success', "Le sinistre a été supprimé.");
            } else {
                return back()->with('error', "Le sinistre n'a pas été supprimé.");
            }
        } else {

            $sinistre->lastname = $request->lastname;
            $sinistre->firstname = $request->firstname;
            $sinistre->brand = $request->brand;
            $sinistre->matricule = $request->matricule;
            $sinistre->contact = $request->contact;
            $sinistre->assurance = $request->assurance;
            $sinistre->tiers = $request->tiers;
            $sinistre->date_open =  $request->date_open;

            if ($sinistre->save()) {
                return back()->with('success', 'Sinistre mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function import(Request $request)
    {
        Excel::import(new SinistresImport, request()->file('file_sinistre'));
        return back()->with('success', 'Fichier importé avec succès.');
    }

    public function export(Request $request)
    {
        $day = Carbon::now();
        return Excel::download(new SinistresExport($request->date_begin, $request->date_end), 'Sinistres - ' . $day . '.xlsx');
    }
}
