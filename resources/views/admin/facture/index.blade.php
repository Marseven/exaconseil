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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Facture</h1>
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
                        <li class="breadcrumb-item text-muted">Suivu de Factures</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Liste des factures Payées</li>
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
                            <h2>Liste des Factures Payées</h2>
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
                                    <th>Numéro</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Agent</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $facture)
                                    <tr>
                                        <td>{{ $facture->id }}</td>
                                        <td>{{ $facture->number_facture }}</td>
                                        <td>{{ $facture->type_prestation }}</td>
                                        <td>{{ $facture->amount }} FCFA</td>
                                        <td>{{ $facture->date_facture }}</td>
                                        <td>{{ $facture->user->lastname . ' ' . $facture->user->firstname }}</td>
                                        <td>{{ $facture->status }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#cardModal{{ $facture->id }}">Modifier</button>
                                            <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#cardModalCenter{{ $facture->id }}">
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
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter une facture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <form action="{{ url('admin/create/cashflow/') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Compagnie d'assurance</label>
                                <input class="form-control" name="company_assurance" type="text"
                                    placeholder="Assurance" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Assuré</label>
                                <input class="form-control" name="assure" type="text" placeholder="Assuré" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Tiers</label>
                                <input class="form-control" name="tiers" type="text" placeholder="Tiers" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Véhicule</label>
                                <input class="form-control" name="vehicule" type="text" placeholder="Véhicule" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Immatriculation</label>
                                <input class="form-control" name="immatriculation" type="text"
                                    placeholder="Immatriculation" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Référence Sinistre</label>
                                <input class="form-control" name="ref_sinistre" type="text"
                                    placeholder="Référence" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de sinistre</label>
                                <input class="form-control" name="date_sinistre" type="date"
                                    placeholder="Date de sinistre" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de mission</label>
                                <input class="form-control" name="date_mission" type="date"
                                    placeholder="Date de mission" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Ville</label>
                                <input class="form-control" name="place" type="text" placeholder="Ville" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Type de prestation</label>
                                <select class="form-control" name="type" required>
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
                                <input class="form-control" name="amount" type="number" placeholder="Montant"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de la facture</label>
                                <input class="form-control" name="date_facture" type="date"
                                    placeholder="Date de début" required />
                            </div>
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
