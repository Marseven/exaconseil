<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DevisExport;
use App\Http\Controllers\Controller;
use App\Imports\DevisImport;
use App\Models\Devis;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DevisController extends Controller
{
    //

    public function index()
    {
        return view('admin.devis.index');
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
        $totalRecords = Devis::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Devis::select('count(*) as allcount')
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('devis.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.brand', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.matricule', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.number_chassis', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.contact', 'like', '%' . $searchValue . '%');
            })->count();

        // Fetch records
        $records = Devis::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('devis.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.brand', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.matricule', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.number_chassis', 'like', '%' . $searchValue . '%')
                    ->orWhere('devis.contact', 'like', '%' . $searchValue . '%');
            })
            ->select('devis.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $record->load(['user']);

            $id = $record->id;

            $name = $record->name;
            $brand = $record->brand;
            $matricule = $record->matricule;
            $chassis = $record->number_chassis;
            $contact = $record->contact;
            $created_at = date_format(date_create($record->created_at), 'd-m-Y');

            $actions = '<button style="padding: 10px !important" type="button"
            class="btn btn-primary modal_view_action"
            data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalView' . $record->id . '"><i
                class="bi bi-eye"></i></button> ';




            if ($role->hasPermissionTo('edit devis') && $user->hasService("Devis") && Controller::isBefore($record->created_at)) {
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
                "name" => $name,
                "brand" => $brand,
                "matricule" => $matricule,
                "contact" => $contact,
                "number_chassis" => $chassis,
                "created_at" => $created_at,
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
        $devis = Devis::find($request->id);
        $title = "";
        if ($request->action == "view") {
            $devis->load(['user']);

            $title = "Police d'assurance N°" . $devis->id;
            $body = ' <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Nom Complet</h6>
                <p class="text-uppercase mb-0">' . $devis->name . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Marque </h6>
                <p class="mb-0">' . $devis->brand . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Matricule
                </h6>
                <p class="mb-0">' . $devis->matricule . ' XAF</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">N° de Châssis
                </h6>
                <p class="mb-0">' . $devis->number_chassis . ' XAF</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Contact
                </h6>
                <p class="mb-0">' . $devis->contact . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de création
                </h6>
                <p class="mb-0">' . date_format(date_create($devis->created_at), 'd-m-Y') . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ajouté par
                </h6>
                <p class="mb-0">' . $devis->user->lastname . ' ' . $devis->user->firstname . '</p>
            </div>';

            $body .= '</div>';
        } elseif ($request->action == "edit") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour le devis N° : ' . $devis->id . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/devis/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Nom Complet</label>
                        <input class="form-control" name="name" type="text" placeholder="Nom Complet"
                            value="' . $devis->name . '" required />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Marque</label>
                        <input class="form-control" name="brand" type="text" placeholder="Marque"
                            value="' . $devis->brand . '" />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Matricule</label>
                        <input class="form-control" name="matricule" type="text" placeholder="Matricule"
                            value="' . $devis->matricule . '" required />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-style-1">
                        <label>N° de Châssis</label>
                        <input class="form-control" name="number_chassis" type="text"
                            placeholder="N° de Chassis" value="' . $devis->number_chassis . '" required />
                    </div>
                </div>


                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Contact</label>
                        <input class="form-control" name="contact" type="tel" placeholder="Contact"
                            value="' . $devis->contact . '" required />
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
            <form method="POST" action="' . url('admin/devis/' . $request->id) . '">
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
            'name' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'matricule' => ['required', 'string'],
            'contact' => ['required', 'string'],
            'number_chassis' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('error', $errors->first());
        }

        $devis = new Devis();

        $devis->name = $request->name;
        $devis->brand = $request->brand;
        $devis->matricule = $request->matricule;
        $devis->contact = $request->contact;
        $devis->number_chassis =  $request->number_chassis;
        $devis->entreprise_id = Auth::user()->entreprise_id;
        $devis->user_id = Auth::user()->id;

        if ($devis->save()) {
            return back()->with('success', 'devis créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, devis $devis)
    {
        if (isset($_POST['delete'])) {
            if ($devis->delete()) {
                return back()->with('success', "Le debis a été supprimé.");
            } else {
                return back()->with('error', "Le devis n'a pas été supprimé.");
            }
        } else {

            $devis->name = $request->name;
            $devis->brand = $request->brand;
            $devis->matricule = $request->matricule;
            $devis->contact = $request->contact;
            $devis->number_chassis =  $request->number_chassis;

            if ($devis->save()) {
                return back()->with('success', 'Devis mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function import(Request $request)
    {
        Excel::import(new DevisImport, request()->file('file_devis'));
        return back()->with('success', 'Fichier importé avec succès.');
    }

    public function export(Request $request)
    {
        $day = Carbon::now();
        return Excel::download(new DevisExport($request->begin, $request->end), 'Devis - ' . $day . '.xlsx');
    }
}
