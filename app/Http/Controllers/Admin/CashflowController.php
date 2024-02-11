<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use App\Models\Cashflow;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    //
    public function index()
    {
        $cashflows = Cashflow::all();
        $cashboxes = Cashbox::where('entreprise_id', Auth::user()->entreprise_id)->get();
        return view('admin.cashflow.index', compact('cashflows', 'cashboxes'));
    }

    public function ajaxList(Request $request, $type)
    {
        $today = new \DateTime(date('Y-m-d'));
        $today = $today->format('Y-m-d');
        $sign = '>';
        if ($type == 'expired') $sign = '<=';


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
        $totalRecords = Policy::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Policy::select('count(*) as allcount')
            ->where('date_expired', $sign, $today)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('policies.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('policies.brand', 'like', '%' . $searchValue . '%')
                    ->orWhere('policies.matricule', 'like', '%' . $searchValue . '%')
                    ->orWhere('policies.contact', 'like', '%' . $searchValue . '%');
            })->count();

        // Fetch records
        $records = Policy::orderBy($columnName, $columnSortOrder)
            ->where('date_expired', $sign, $today)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('policies.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('policies.brand', 'like', '%' . $searchValue . '%')
                    ->orWhere('policies.matricule', 'like', '%' . $searchValue . '%')
                    ->orWhere('policies.contact', 'like', '%' . $searchValue . '%');
            })
            ->select('policies.*')
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
            $contact = $record->contact;
            $date_begin = date_format(date_create($record->date_begin), 'd-m-Y');
            $date_expired = date_format(date_create($record->date_expired), 'd-m-Y');

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
                "name" => $name,
                "brand" => $brand,
                "matricule" => $matricule,
                "contact" => $contact,
                "date_begin" => $date_begin,
                "date_expired" => $date_expired,
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
        $policy = Policy::find($request->id);
        $title = "";
        if ($request->action == "view") {
            $policy->load(['user']);

            $title = "Police d'assurance N°" . $policy->id;
            $body = ' <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Nom Complet</h6>
                <p class="text-uppercase mb-0">' . $policy->name . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Marque </h6>
                <p class="mb-0">' . $policy->brand . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Matricule
                </h6>
                <p class="mb-0">' . $policy->matricule . ' XAF</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Contact
                </h6>
                <p class="mb-0">' . $policy->contact . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date de début
                </h6>
                <p class="mb-0">' . date_format(date_create($policy->date_begin), 'd-m-Y') . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date d\'expiration
                </h6>
                <p class="mb-0">' . date_format(date_create($policy->date_expired), 'd-m-Y') . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Ajouté par
                </h6>
                <p class="mb-0">' . $policy->user->lastname . ' ' . $policy->user->firstname . '</p>
            </div>';

            $body .= '</div>';
        } elseif ($request->action == "edit") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour la police N° : ' . $policy->id . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/policy/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Nom Complet</label>
                        <input class="form-control" name="name" type="text" placeholder="Nom Complet"
                            value="' . $policy->name . '" required />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Marque</label>
                        <input class="form-control" name="brand" type="text" placeholder="Marque"
                            value="' . $policy->brand . '" />
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Matricule</label>
                        <input class="form-control" name="matricule" type="text" placeholder="Matricule"
                            value="' . $policy->matricule . '" required />
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Contact</label>
                        <input class="form-control" name="contact" type="tel" placeholder="Contact"
                            value="' . $policy->contact . '" required />
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Date de Début</label>
                        <input class="form-control" name="date_begin" type="date"
                            placeholder="Date de début" value="' . $policy->date_begin . '" required />
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-style-1">
                        <label>Date d\'Expiration</label>
                        <input class="form-control" name="date_expired" type="date"
                            placeholder="Date d\'expiration" value="' . $policy->date_expired . '" required />
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
            <form method="POST" action="' . url('admin/policy/' . $request->id) . '">
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

    public function cashbox()
    {
        $cashboxs = Cashbox::all();
        $entreprises = Entreprise::all();
        $cashboxs->load(['entreprise']);
        return view('admin.cashflow.cashbox', compact('cashboxs', 'entreprises'));
    }

    public function createCashbox(Request $request)
    {

        $cashbox = new Cashbox();

        $cashbox->name = $request->name;
        $cashbox->solde = $request->solde;
        $cashbox->user_id = Auth::user()->id;
        $cashbox->entreprise_id = $request->entreprise_id;


        if ($cashbox->save()) {
            return back()->with('success', 'Caisse créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function updateCashbox(Request $request, Cashbox $cashbox)
    {
        if (isset($_POST['delete'])) {
            if ($cashbox->delete()) {
                return back()->with('success', "Le rôle a été supprimé.");
            } else {
                return back()->with('error', "Le rôle n'a pas été supprimé.");
            }
        } else {

            $cashbox->name = $request->name;
            $cashbox->solde = $request->solde;

            if ($cashbox->save()) {
                return back()->with('success', 'Caisse mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function create(Request $request)
    {
        $cashflow = new Cashflow();

        $cashflow->type = $request->type;
        $cashflow->reason = $request->reason;
        $cashflow->amount = $request->amount;
        $cashflow->date_cash = $request->date_cash;
        $cashflow->cashbox_id =  $request->cashbox_id;
        $cashflow->user_id = Auth::user()->id;

        if ($cashflow->save()) {
            return back()->with('success', 'Transaction créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, Cashflow $cashflow)
    {
        if (isset($_POST['delete'])) {
            if ($cashflow->delete()) {
                return back()->with('success', "La transaction a été supprimé.");
            } else {
                return back()->with('error', "La police n'a pas été supprimé.");
            }
        } else {

            $cashflow->type = $request->type;
            $cashflow->reason = $request->reason;
            $cashflow->amount = $request->amount;
            $cashflow->date_cash = $request->date_cash;

            if ($cashflow->save()) {
                return back()->with('success', 'La transaction mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }
}
