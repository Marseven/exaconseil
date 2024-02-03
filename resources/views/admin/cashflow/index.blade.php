@extends('layout.default')

@push('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center me-3 flex-wrap lh-1">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">CashFlow</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin-dashboard') }}" class="text-muted text-hover-primary">Tableau de
                                bord</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Suivu de Caisse</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Liste des transactions</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                @include('layout.alert')

                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Liste des transactions</h2>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Add user-->

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#securityModal">
                                    <i class="ki-duotone ki-plus fs-2"></i>Ajouter</button>

                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->


                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <table class="table" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Raison / Motif</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Caisse</th>
                                    <th>Agent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cashflows as $cashflow)
                                    <tr>
                                        <td>{{ $cashflow->id }}</td>
                                        <td>{{ $cashflow->type }}</td>
                                        <td>{{ $cashflow->reason }}</td>
                                        <td>{{ $cashflow->amount }} FCFA</td>
                                        <td>{{ $cashflow->date_cash }}</td>
                                        <td>{{ $cashflow->cashbox->name }}</td>
                                        <td>{{ $cashflow->user->lastname . ' ' . $cashflow->user->firstname }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#cardModal{{ $cashflow->id }}">Modifier</button>
                                            <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#cardModalCenter{{ $cashflow->id }}">
                                                Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>

    <div class="modal fade" id="securityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelOne"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter une transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <form action="{{ url('admin/create/cashflow/') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Type</label>
                                <select class="form-control" name="type">
                                    <option value="debit">DEBIT</option>
                                    <option value="debit">CREDIT</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Raison / Motif</label>
                                <textarea class="form-control" name="reason" type="text" required></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Montant</label>
                                <input class="form-control" name="amount" type="number" placeholder="Montant" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de la transaction</label>
                                <input class="form-control" name="date_cash" type="date" placeholder="Date de début"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Caisse</label>
                            </div>
                            <select id="selectOne" class="form-control" name="cashbox_id">
                                @foreach ($cashboxes as $cashbox)
                                    <option value="{{ $cashbox->id }}">{{ $cashbox->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="background-color: #2b9753 !important;"
                            class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#kt_datatable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
    </script>
@endpush
