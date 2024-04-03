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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">
                        {{ $type == 'debit' ? 'Sortie de caisse' : 'Entrée de caisse' }}</h1>
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
                        <li class="breadcrumb-item text-muted">Suivi de Caisse</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Liste des
                            {{ $type == 'debit' ? 'sorties de caisse' : 'entrées de caisse' }}</li>
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

                @if ($role->name == 'Gerant')
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    @foreach ($cashboxes as $cashbox)
                                        <button type="button" class="btn btn-secondary m-5">
                                            Solde {{ $cashbox->name }} : {{ $cashbox->solde }} FCFA
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <br>
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
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Select2-->
                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Rubrique" data-kt-filter="rubrique">
                                        <option value="all">Tout</option>
                                        @foreach ($rubriques as $rubrique)
                                            <option value="{{ $rubrique->id }}">{{ $rubrique->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <!--end::Select2-->
                                <!--begin::Add user-->

                                <button type="button" class="btn btn-primary m-5" data-bs-toggle="modal"
                                    data-bs-target="#securityModal">
                                    <i class="ki-duotone ki-plus fs-2"></i>Ajouter</button>
                                <button type="button" class="btn btn-secondary m-5" data-bs-toggle="modal"
                                    data-bs-target="#export">
                                    <i class="bi bi-download fs-2"></i>Exporter</button>
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
                                    <th>Rubrique</th>
                                    <th>Raison / Motif</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Caisse</th>
                                    <th>Agent</th>
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
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter une transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <form action="{{ url('admin/create/cashflow/') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label required">Type</label>
                                <select class="form-control" name="type">
                                    <option value="debit">DEBIT</option>
                                    <option value="credit">CREDIT</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Rubrique</label>
                            </div>
                            <select id="selectOne" class="form-control" name="rubrique_id" data-control="select2"
                                required>
                                @foreach ($rubriques as $rubrique)
                                    <option value="{{ $rubrique->id }}">{{ $rubrique->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="reason" type="text"></textarea>
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
                                <label class="form-label required">Date de la transaction</label>
                                <input class="form-control" name="date_cash" type="date" placeholder="Date de début"
                                    required />
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
                                <label class="form-label required">Caisse</label>
                            </div>
                            <select id="selectOne" class="form-control" name="cashbox_id" required>
                                @foreach ($cashboxes as $cashbox)
                                    <option value="{{ $cashbox->id }}">{{ $cashbox->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Service</label>
                            </div>
                            <select target="entity" id="service" class="form-control linked-select" name="service_id">
                                <option value='-1'>Choisir</option>
                                @foreach ($services as $service)
                                    <option id="service_{{ $service->id }}" data-name="{{ $service->name }}"
                                        value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Élément du service</label>
                            </div>
                            <select id="entity" class="form-control" name="entity_id[]" data-control="select2"
                                data-close-on-select="false" data-placeholder="Choisir" data-allow-clear="true"
                                multiple="multiple">
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

    @if ($role->hasPermissionTo('edit cashflow') && $user->hasService('Caisse'))
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
                        Êtes-vous sûr de vouloir supprimer cette transaction ?
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
                <form action="{{ route('admin-export-cashflow') }}" method="POST">
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
@endsection

@push('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        "use strict";

        $(".linked-select").change(function() {
            var id = $(this).val();
            var target = $(this).attr('target');
            var name = $("#service_" + id).data('name');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery(
                            'meta[name="csrf-token"]')
                        .attr('content')
                },
                url: "{{ route('admin-select-service') }}",
                data: {
                    'id': id,
                },
                method: 'POST',
                dataType: 'json',
                success: function(result) {

                    result = JSON.parse(result);
                    var option_html = "<option value='-1'>Choisir</option>";
                    let j = 0;
                    let el_id = "";
                    for (j = 0; j < result.length; j++) {
                        el_id = result[j].id;
                        if (name == "Facture") el_id = result[j].number_facture;
                        var is_selected = $("#" + target).data('val') == result[j].id ? 'selected' : '';
                        option_html += "<option " + is_selected + "  value='" + result[j].id +
                            "'>  " + name + " N°" + el_id + "</option>";
                    }

                    $("#" + target).html(option_html);
                    $("#" + target).change();
                }
            });
        });

        $(".linked-select").change();

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
                    ajax: "{{ url('admin/ajax/cashflows/' . $type) }}",
                    columnDefs: [{
                        className: "upper",
                        targets: [1]
                    }],
                    order: [
                        [5, 'desc']
                    ],
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'rubrique_id',
                        },
                        {
                            data: 'reason'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'date_cash'
                        },
                        {
                            data: 'cashbox'
                        },
                        {
                            data: 'agent'
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
                const t = document.querySelector('[data-kt-filter="rubrique"]');
                $(t).on("change", (t => {
                    let n = t.target.value;
                    console.log(n);
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
                url: "{{ route('admin-ajax-cashflow') }}",
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
                url: "{{ route('admin-ajax-cashflow') }}",
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
                url: "{{ route('admin-ajax-cashflow') }}",
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
