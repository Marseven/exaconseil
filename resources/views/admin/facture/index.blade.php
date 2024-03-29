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
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon fs-1 position-absolute ms-4"><i class="bi bi-search fs-2"></i></span>
                                <input type="text" data-kt-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher" />
                            </div>
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                            <!--begin::Toolbar-->
                            <!--begin::Select2-->
                            <div class="w-100 mw-150px">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                    data-placeholder="Assurance" data-kt-filter="assurance">
                                    <option value="all">Tout</option>
                                    @foreach ($assurances as $assurance)
                                        <option value="{{ $assurance->name }}">{{ $assurance->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Select2-->
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#securityModal">
                                <i class="ki-duotone ki-plus fs-2"></i>Ajouter</button>
                            <!--end::Add user-->
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
                                    <th>Maison d'Assurance</th>
                                    <th>Numéro</th>
                                    <th>Courtier d'Assurance</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Agent</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
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
                <form action="{{ url('admin/create/facture/') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Type de prestation</label>
                                <select class="form-control" name="type_prestation" id="type_prestation"
                                    onchange="viewParticulier()" required>
                                    <option value="Standard">Standard</option>
                                    <option value="Particulier">Particulier</option>
                                    <option value="Intérieur">Intérieur</option>
                                    <option value="Flotte">Flotte</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="maison-assasurance">
                            <div class="input-style-1">
                                <label class="form-label required">Maison d'assurance</label>
                                <select class="form-control" name="assurance_id">
                                    <option value="0">Choisir</option>
                                    @foreach ($assurances as $assurance)
                                        <option value="{{ $assurance->name }}">{{ $assurance->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Mandat</label>
                                <select class="form-control" name="mandat_id">
                                    <option value="0">Choisir</option>
                                    @foreach ($mandats as $mandat)
                                        @if ($mandat->facture->count() == 0)
                                            <option value="{{ $mandat->id }}">Mandat N°{{ $mandat->number_mandat }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Numéro de facture</label>
                                <input class="form-control" name="number_facture" type="text"
                                    placeholder="N° de facture" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Courtier d'assurance</label>
                                <input class="form-control" name="company_assurance" type="text"
                                    placeholder="Assurance" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Assuré</label>
                                <input class="form-control" name="assure" type="text" placeholder="Assuré"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Tiers</label>
                                <input class="form-control" name="tiers" type="text" placeholder="Tiers"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Véhicule</label>
                                <input class="form-control" name="vehicule" type="text" placeholder="Véhicule"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Immatriculation</label>
                                <input class="form-control" name="immatriculation" type="text"
                                    placeholder="Immatriculation" required />
                            </div>
                        </div>

                        <div class="mb-3" id="ref-sinistre">
                            <div class="input-style-1">
                                <label class="form-label required">Référence sinistre</label>
                                <input class="form-control" name="ref_sinistre" type="text" placeholder="Référence"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3" id="date-sinistre">
                            <div class="input-style-1">
                                <label class="form-label required">Date de sinistre</label>
                                <input class="form-control" name="date_sinistre" type="date"
                                    placeholder="Date de sinistre" required />
                            </div>
                        </div>
                        <div class="mb-3" id="date-mission">
                            <div class="input-style-1">
                                <label class="form-label required">Date de mission</label>
                                <input class="form-control" name="date_mission" type="date"
                                    placeholder="Date de mission" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Ville</label>
                                <input class="form-control" name="place" type="text" placeholder="Ville"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Montant</label>
                                <input class="form-control" name="amount" type="number" placeholder="Montant"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date de la facture</label>
                                <input class="form-control" name="date_facture" type="date"
                                    placeholder="Date de début" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Pièce Jointe</label>
                                <input class="form-control" name="facture_physical" type="file" />
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

    @if ($role->hasPermissionTo('edit facture') && $user->hasService('Facture'))
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
                        Êtes-vous sûr de vouloir supprimer cette facture ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        "use strict";

        function viewParticulier() {
            var type_prestation = document.getElementById("type_prestation");
            var assasurance = document.getElementById("maison-assasurance");
            var mission = document.getElementById("date-mission");
            var date = document.getElementById("date-sinistre");
            var ref = document.getElementById("ref-sinistre");

            if (type_prestation.value == "Particulier") {
                assurance.style.display = "none";
                mission.style.display = "none";
                date.style.display = "none";
                ref.style.display = "none";
            } else {
                assurance.style.display = "block";
                mission.style.display = "block";
                date.style.display = "block";
                ref.style.display = "block";
            }
        }

        // Class definition
        var KTDatatablesExample = function() {
            // Shared variables
            var table;
            var datatable;

            // Private functions
            var initDatatable = function() {
                // Set date data order

                // Init datatable --- more info on datatables: https://datatables.net/manual/
                datatable = $(table).DataTable({
                    language: {
                        'url': "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                    },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ajax: "{{ url('admin/ajax/factures/paid') }}",
                    columnDefs: [{
                        className: "upper",
                        targets: [1]
                    }],
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'assurance'
                        },
                        {
                            data: 'number_facture'
                        },
                        {
                            data: 'courtier'
                        },
                        {
                            data: 'type_prestation'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'date_facture'
                        },
                        {
                            data: 'user'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'actions'
                        },
                    ]

                });
            }

            // Hook export buttons

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-kt-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    datatable.search(e.target.value).draw();
                });
            }
            var filterDatatable = () => {
                const t = document.querySelector('[data-kt-filter="assurance"]');
                $(t).on("change", (t => {
                    let n = t.target.value;
                    "all" === n && (n = ""),
                        datatable.search(n).draw()
                }));
            }

            // Public methods
            return {
                init: function() {
                    table = document.querySelector('#kt_datatable');

                    if (!table) {
                        return;
                    }

                    initDatatable();
                    handleSearchDatatable();
                    filterDatatable();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesExample.init();
        });

        $(document).on("click", ".modal_view_action", function() {

            var id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-facture') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "view",
                },
                success: function(data) {
                    //get data value params
                    var title = data.title;
                    var body = data.body;

                    $('#cardModalView .modal-title').text(title); //dynamic title
                    $('#cardModalView .modal-body').html(body); //url to delete item
                    $('#cardModalView').modal('show');
                }
            });

            //show the modal
        });

        $(document).on("click", ".modal_edit_action", function() {
            var id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-facture') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "edit",
                },
                success: function(data) {
                    //get data value params
                    var body = data.body;
                    //dynamic title
                    $('#cardModal .modal-content').html(body); //url to delete item
                    $('#cardModal').modal('show');
                }
            });

        });

        $(document).on("click", ".modal_delete_action", function() {
            var id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('admin-ajax-facture') }}",
                dataType: 'json',
                data: {
                    "id": id,
                    "action": "delete",
                },
                success: function(data) {
                    //get data value params
                    var body = data.body;
                    //dynamic title
                    $('#cardModalCenter .modal-footer').html(body); //url to delete item
                    $('#cardModalCenter').modal('show');
                }
            });
        });
    </script>
@endpush
