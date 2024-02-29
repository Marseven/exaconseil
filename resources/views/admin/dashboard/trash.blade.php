@extends('layout.default')

@push('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@php
    $user = Auth::user();
    $user->load(['entreprise']);
    $role = $user->roles->first();
@endphp

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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Corbeille</h1>
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
                        <li class="breadcrumb-item text-muted">Corbeille</li>
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

                    <!--begin::Card body-->
                    <div class="card-body py-4">

                        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                            @if ($user->hasService("Police d'assurance"))
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Police</a>
                                </li>
                            @endif
                            @if ($user->hasService('Sinistre'))
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Sinistre</a>
                                </li>
                            @endif
                            @if ($user->hasService('Devis'))
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Devis</a>
                                </li>
                            @endif
                            @if ($user->hasService('Mandat'))
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4">Mandant</a>
                                </li>
                            @endif
                            @if ($user->hasService('Facture'))
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">Facture</a>
                                </li>
                            @endif
                            @if ($user->hasService('Caisse'))
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_7">Caisse</a>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                <!--begin::Table-->
                                <table class="table" id="kt_datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Nom & Prénoms</th>
                                            <th>Marque</th>
                                            <th>Matricule</th>
                                            <th>Contact</th>
                                            <th>Date de Début</th>
                                            <th>Date d'Expiration</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($policies as $policy)
                                            <tr>
                                                <td>{{ $policy->id }}</td>
                                                <td>{{ $policy->type }}</td>
                                                <td>{{ $policy->name }}</td>
                                                <td>{{ $policy->brand }}</td>
                                                <td>{{ $policy->matricule }}</td>
                                                <td>{{ $policy->contact }}</td>
                                                <td>{{ $policy->date_begin }}</td>
                                                <td>{{ $policy->date_expired }}</td>
                                                <td>
                                                    <a href="{{ url('admin/restore/Police/' . $policy->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-secondary">
                                                            <i class="bi bi-arrow-bar-left"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/delete/trash/Police/' . $policy->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                <!--begin::Table-->
                                <table class="table" id="kt_datatable_2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom & Prénoms</th>
                                            <th>Marque</th>
                                            <th>Matricule</th>
                                            <th>Contact</th>
                                            <th>Assurance</th>
                                            <th>Tiers</th>
                                            <th>Date d'ouverture</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sinistres as $sinistre)
                                            <tr>
                                                <td>{{ $sinistre->id }}</td>
                                                <td>{{ $sinistre->name }}</td>
                                                <td>{{ $sinistre->brand }}</td>
                                                <td>{{ $sinistre->matricule }}</td>
                                                <td>{{ $sinistre->contact }}</td>
                                                <td>{{ $sinistre->assurance }}</td>
                                                <td>{{ $sinistre->tiers }}</td>
                                                <td>{{ $sinistre->date_open }}</td>
                                                <td>
                                                    <a href="{{ url('admin/restore/Sinistre/' . $sinistre->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-secondary">
                                                            <i class="bi bi-arrow-bar-left"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/delete/trash/Sinistre/' . $sinistre->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                                <!--begin::Table-->
                                <table class="table" id="kt_datatable_3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Société / Particlier</th>
                                            <th>Marque</th>
                                            <th>Matricule</th>
                                            <th>N° de châssis</th>
                                            <th>Contact</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($devis as $devi)
                                            <tr>
                                                <td>{{ $devi->id }}</td>
                                                <td>{{ $devi->name }}</td>
                                                <td>{{ $devi->brand }}</td>
                                                <td>{{ $devi->matricule }}</td>
                                                <td>{{ $devi->number_chassis }}</td>
                                                <td>{{ $devi->contact }}</td>
                                                <td>
                                                    <a href="{{ url('admin/restore/Devis/' . $devi->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-secondary">
                                                            <i class="bi bi-arrow-bar-left"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/delete/trash/Devis/' . $devi->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                                <!--begin::Table-->
                                <table class="table" id="kt_datatable_4">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>N° Mandat</th>
                                            <th>Assuré</th>
                                            <th>Tiers</th>
                                            <th>Véhicule</th>
                                            <th>Immatriculation</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mandats as $mandat)
                                            <tr>
                                                <td>{{ $mandat->id }}</td>
                                                <td>{{ $mandat->number_mandat }}</td>
                                                <td>{{ $mandat->assure }}</td>
                                                <td>{{ $mandat->tiers }}</td>
                                                <td>{{ $mandat->vehicule }}</td>
                                                <td>{{ $mandat->immatricualtion }}</td>
                                                <td>
                                                    <a href="{{ url('admin/restore/Mandat/' . $mandat->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-secondary">
                                                            <i class="bi bi-arrow-bar-left"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/delete/trash/Mandat/' . $mandat->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                                <!--begin::Table-->
                                <table class="table" id="kt_datatable_5">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Maison d'Assurance</th>
                                            <th>Numéro</th>
                                            <th>Type</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($factures as $facture)
                                            <tr>
                                                <td>{{ $facture->id }}</td>
                                                <td>{{ $facture->company_assurance }}</td>
                                                <td>{{ $facture->number_facture }}</td>
                                                <td>{{ $facture->type_prestation }}</td>
                                                <td>{{ $facture->amount }}</td>
                                                <td>{{ $facture->date_facture }}</td>
                                                <td>{{ $facture->status }}</td>
                                                <td>
                                                    <a href="{{ url('admin/restore/Facture/' . $facture->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-secondary">
                                                            <i class="bi bi-arrow-bar-left"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/delete/trash/Facture/' . $facture->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>

                            <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">
                                <!--begin::Table-->
                                <table class="table" id="kt_datatable_7">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Raison / Motif</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th>Caisse</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cashflows as $cashflow)
                                            @php
                                                $cashflow->load(['cashbox']);
                                            @endphp
                                            <tr>
                                                <td>{{ $cashflow->id }}</td>
                                                <td>{{ $cashflow->type }}</td>
                                                <td>{{ $cashflow->reason }}</td>
                                                <td>{{ $cashflow->date_cash }}</td>
                                                <td>{{ $cashflow->cashbox->name }}</td>
                                                <td>
                                                    <a href="{{ url('admin/restore/Caisse/' . $cashflow->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-secondary">
                                                            <i class="bi bi-arrow-bar-left"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ url('admin/delete/trash/Caisse/' . $cashflow->id) }}"
                                                        onclick="confirm('Êtes-vous sûr de vouloir effectuer cette action ?')">
                                                        <button style="padding: 10px !important" type="button"
                                                            class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->


        </div>
        <!--end::Post-->
    </div>


    <div class="modal fade" id="cardModalView" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelOne"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelOne"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cardModalCenter" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer définitivement cet élément ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                </div>
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
        $(document).ready(function() {
            $('#kt_datatable_2').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
        $(document).ready(function() {
            $('#kt_datatable_3').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
        $(document).ready(function() {
            $('#kt_datatable_4').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
        $(document).ready(function() {
            $('#kt_datatable_5').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
        $(document).ready(function() {
            $('#kt_datatable_6').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
        $(document).ready(function() {
            $('#kt_datatable_7').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                }
            });
        });
    </script>
@endpush
