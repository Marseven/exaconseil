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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Polices d'Assurance</h1>
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
                        <li class="breadcrumb-item text-muted">Suivi des Polices d'Assurances</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Liste des polices d'assurance en cours</li>
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
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                            <div class="w-100 mw-150px">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                    data-placeholder="Type" data-kt-filter="type">
                                    <option value="all">Tout</option>
                                    <option value="client">Client</option>
                                    <option value="prospect">Prospect</option>

                                </select>
                                <!--end::Select2-->
                            </div>

                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Add user-->
                                <button type="button" class="btn btn-primary m-5" data-bs-toggle="modal"
                                    data-bs-target="#securityModal">
                                    <i class="ki-duotone ki-plus fs-2"></i>Ajouter</button>

                                <button type="button" class="btn btn-secondary m-5" data-bs-toggle="modal"
                                    data-bs-target="#export">
                                    <i class="bi bi-download fs-2"></i>Exporter</button>

                                <button type="button" class="btn btn-success m-5" data-bs-toggle="modal"
                                    data-bs-target="#import">
                                    <i class="bi bi-upload fs-2"></i>Impoter</button>

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
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter une police</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <form action="{{ url('admin/create/policy/') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Type</label>
                                <select class="form-control" name="type" required>
                                    <option value="client">Client</option>
                                    <option value="prospect">Prospect</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Nom Complet</label>
                                <input class="form-control" name="name" type="text" placeholder="Nom Complet"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Marque</label>
                                <input class="form-control" name="brand" type="text" placeholder="Marque"
                                    required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Matricule</label>
                                <input class="form-control" name="matricule" type="text" placeholder="Matricule" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Contact</label>
                                <input class="form-control" name="contact" type="tel" placeholder="Contact"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date de Début</label>
                                <input class="form-control" name="date_begin" type="date"
                                    placeholder="Date de début" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Date d'Expiration</label>
                                <input class="form-control" name="date_expired" type="date"
                                    placeholder="Date d'expiration" />
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
    @if ($role->hasPermissionTo('edit policy') && $user->hasService('Police d\'assurance'))
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
                        Êtes-vous sûr de vouloir supprimer cette police d'assurance ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="export" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Exporter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('admin-export-policy') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de Début</label>
                                <input class="form-control" name="date_begin" type="date" placeholder="Date de début"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date de fin</label>
                                <input class="form-control" name="date_end" type="date"
                                    placeholder="Date d'expiration" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="import" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Importer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('admin-import-policy') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Uploader le fichier</label>
                                <input class="form-control" name="file_policies" type="file" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        "use strict";

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
                    ajax: "{{ url('admin/ajax/policies/valided') }}",
                    columnDefs: [{
                        className: "upper",
                        targets: [1]
                    }],
                    order: [
                        [7, 'asc']
                    ],
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'brand'
                        },
                        {
                            data: 'matricule'
                        },
                        {
                            data: 'contact'
                        },
                        {
                            data: 'date_begin'
                        },
                        {
                            data: 'date_expired'
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
                const t = document.querySelector('[data-kt-filter="type"]');
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
                url: "{{ route('admin-ajax-policy') }}",
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
                url: "{{ route('admin-ajax-policy') }}",
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
                url: "{{ route('admin-ajax-policy') }}",
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
