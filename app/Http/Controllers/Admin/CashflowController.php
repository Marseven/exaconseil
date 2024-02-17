<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CashflowExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\Cashbox;
use App\Models\Cashflow;
use App\Models\Devis;
use App\Models\Entreprise;
use App\Models\Facture;
use App\Models\Policy;
use App\Models\Service;
use App\Models\Sinistre;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CashflowController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->entreprise_id == 0) {
            $cashboxes = Cashbox::all();
            $services = Service::all();
        } else {
            $entrepriseId = Auth::user()->entreprise_id;
            $cashboxes = Cashbox::where('entreprise_id', $entrepriseId)->get();
            $entreprise = Entreprise::with('services')->find($entrepriseId);
            $services = $entreprise->services()->whereNot('name', "Caisse")->get();
        }

        return view('admin.cashflow.index', compact('cashboxes', 'services'));
    }

    public function ajaxList(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->load(['entreprise']);
        $role = $user->roles->first();
        if ($user->entreprise_id == 0) {
            $cashbox = Cashbox::all();
        } else {
            $cashbox = Cashbox::where('entreprise_id', $user->entreprise_id)->get();
        }
        $cashboxs = [];
        foreach ($cashbox as $cash) {
            $cashboxs[] = $cash->id;
        }

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
        $totalRecords = Cashflow::whereIn('cashbox_id', $cashboxs)->select('count(*) as allcount')->count();
        $totalRecordswithFilter = Cashflow::select('count(*) as allcount')
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('cashflows.type', 'like', '%' . $searchValue . '%')
                    ->orWhere('cashflows.reason', 'like', '%' . $searchValue . '%')
                    ->orWhere('cashflows.amount', 'like', '%' . $searchValue . '%');
            })->whereIn('cashbox_id', $cashboxs)->count();

        // Fetch records
        $records = Cashflow::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) {
                $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
                $query->where('cashflows.type', 'like', '%' . $searchValue . '%')
                    ->orWhere('cashflows.reason', 'like', '%' . $searchValue . '%')
                    ->orWhere('cashflows.amount', 'like', '%' . $searchValue . '%');
            })->whereIn('cashbox_id', $cashboxs)
            ->select('cashflows.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $record->load(['user', 'cashbox']);

            $id = $record->id;
            $type = $record->type == 'credit' ? 'CREDIT' : 'DEBIT';
            $reason = $record->reason;
            $amount = Controller::format_amount($record->amount) . " FCFA";
            $caisse = $record->cashbox->name;
            $_user = $record->user->firstname . ' ' . $record->user->lastname;
            $date = date_format(date_create($record->date_cash), 'd-m-Y');

            $actions = '<button style="padding: 10px !important" type="button"
            class="btn btn-primary modal_view_action"
            data-bs-toggle="modal"
            data-id="' . $record->id . '"
            data-bs-target="#cardModalView' . $record->id . '"><i
                class="bi bi-eye"></i></button> ';


            if ($role->hasPermissionTo('edit cashflow') && $user->hasService('Facture')) {
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
                "type" => $type,
                "reason" => $reason,
                "amount" => $amount,
                "date_cash" => $date,
                "cashbox" => $caisse,
                "agent" => $_user,
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
        $cashflow = Cashflow::find($request->id);
        if (Auth::user()->entreprise_id == 0) {
            $cashboxes = Cashbox::all();
            $services = Service::all();
        } else {
            $entrepriseId = Auth::user()->entreprise_id;
            $cashboxes = Cashbox::where('entreprise_id', $entrepriseId)->get();
            $entreprise = Entreprise::with('services')->find($entrepriseId);
            $services = $entreprise->services;
        }
        $title = "";
        if ($request->action == "view") {
            $cashflow->load(['user', 'service', 'cashbox']);

            $title = "Transaction N°" . $cashflow->id;
            $body = ' <div class="row"><div class="col-6 mb-5"><h6 class="text-uppercase fs-5 ls-2">Type</h6>
                <p class="text-uppercase mb-0">' . $cashflow->type . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Raison </h6>
                <p class="mb-0">' . $cashflow->reason . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Montant
                </h6>
                <p class="mb-0">' . Controller::format_amount($cashflow->amount) . ' FCFA</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Date
                </h6>
                <p class="mb-0">' .  date_format(date_create($cashflow->date_cash), 'd-m-Y') . '</p>
            </div>
            <div class="col-6 mb-5">
                <h6 class="text-uppercase fs-5 ls-2">Service
                </h6>
                <p class="mb-0">' . $cashflow->service->name . '</p>
            </div>
            ';
            if ($cashflow->piece_url) {
                $body .= '<div class="col-6 mb-5">
                    <h6 class="text-uppercase fs-5 ls-2">Pièce Jointe
                    </h6>
                    <p class="mb-0"><a target="_blank" href="' . asset($cashflow->piece_url) . '"
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
                <p class="mb-0">' . $cashflow->user->lastname . ' ' . $cashflow->user->firstname . '</p>
            </div>';

            $body .= '</div>';
        } elseif ($request->action == "edit") {

            $body = '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour la transaction N° : ' . $cashflow->id . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>

            <form action="' . url('admin/cashflow/' . $request->id) . '" method="POST">
                <div class="modal-body">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="mb-3">
                            <div class="input-style-1">
                                <label>Type</label>
                                <select class="form-control" name="type">
                                    <option>' . $cashflow->type . '</option>
                                    <option value="debit">DEBIT</option>
                                    <option value="credit">CREDIT</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Raison / Motif</label>
                                <textarea class="form-control" name="reason" type="text" required>' . $cashflow->reason . '</textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Montant</label>
                                <input class="form-control" name="amount" type="number" placeholder="Montant" value="' . $cashflow->amount . '" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de la transaction</label>
                                <input class="form-control" name="date_cash" type="date" placeholder="Date de transaction"
                                    required value="' . $cashflow->date_cash . '" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Justificatif / Pièce jointe</label>
                                <input class="form-control" name="piece" type="file" placeholder="Justificatif" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Caisse</label>
                            </div>
                            <select id="selectOne" class="form-control" name="cashbox_id" required>';
            foreach ($cashboxes as $cashbox) {
                if ($cashbox->id == $cashflow->cashbox_id) {
                    $body .= '<option selected value="' . $cashbox->id . '">' . $cashbox->name . '</option>';
                } else {
                    $body .= '<option value="' . $cashbox->id . '">' . $cashbox->name . '</option>';
                }
            }
            $body .= '</select>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Service</label>
                            </div>
                            <select id="selectOne" class="form-control" name="service_id">';
            foreach ($services as $service) {
                if ($service->id == $cashflow->service_id) {
                    $body .= '<option selected value="' . $service->id . '">' . $service->name . '</option>';
                } else {
                    $body .= '<option value="' . $service->id . '">' . $service->name . '</option>';
                }
            }

            $body .= ' </select>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Élément du service</label>
                            </div>
                            <select id="selectOne" class="form-control" name="element_id">
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
            </form>';
        } else {

            $body = '
            <form method="POST" action="' . url('admin/cashflow/' . $request->id) . '">
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
        $user = User::find(Auth::user()->id);
        $user->load(['entreprise']);
        $role = $user->roles->first();

        if ($user->entreprise_id == 0) {
            $entreprises = Entreprise::all();
            $cashboxs = Cashbox::all();
        } else {
            $entreprises = Entreprise::where('id', $user->entreprise_id)->get();
            $cashboxs = Cashbox::where('entreprise_id', $user->entreprise_id)->get();
        }

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
        $cashflow->service_id =  $request->service_id == -1 ? null : $request->service_id;
        $cashflow->entity_id =  $request->entity_id;

        if ($request->file('piece')) {
            $picture = FileController::piece($request->file('piece'));
            if ($picture['state'] == false) {
                return back()->withErrors($picture['message']);
            }

            $url = $picture['url'];
            $cashflow->piece_url =  $url;
        }

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
            $cashflow->service_id =  $request->service_id;
            $cashflow->entity_id =  $request->entity_id;
            if ($request->file('piece')) {
                $picture = FileController::piece($request->file('piece'));
                if ($picture['state'] == false) {
                    return back()->withErrors($picture['message']);
                }

                $url = $picture['url'];
                $cashflow->piece_url =  $url;
            }

            if ($cashflow->save()) {
                return back()->with('success', 'La transaction mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function export(Request $request)
    {
        $day = Carbon::now();
        return Excel::download(new CashflowExport($request->begin, $request->end), 'Transactions - ' . $day . '.xlsx');
    }

    public function select(Request $request)
    {
        $service = Service::where('id', $request->id)->first();

        $entrepriseId = Auth::user()->entreprise_id == 0 ? 1 : Auth::user()->entreprise_id;

        switch ($service->id) {
            case 1:
                $entities = Policy::where('entreprise_id', $entrepriseId)->get();
                break;
            case 2:
                $entities = Sinistre::where('entreprise_id', $entrepriseId)->get();
                break;
            case 3:
                $entities = Devis::where('entreprise_id', $entrepriseId)->get();
                break;
            case 5:
                $entities = Facture::where('entreprise_id', $entrepriseId)->get();
                break;
            default:
                $entities = [];
                break;
        }



        $response = json_encode($entities);

        return response()->json($response);
    }
}
