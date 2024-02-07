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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Sinistre</h1>
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
                        <li class="breadcrumb-item text-muted">Suivi des Sinistres</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Liste des sinistres</li>
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
                            <h2>Liste des sinistres</h2>
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
                                            <button class="btn btn-xs btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#cardModal{{ $sinistre->id }}">Modifier</button>
                                            <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#cardModalCenter{{ $sinistre->id }}">
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
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter un sinistre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <form action="{{ url('admin/create/sinistre/') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Nom</label>
                                <input class="form-control" name="lastname" type="text" placeholder="Nom" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Prénom</label>
                                <input class="form-control" name="firstname" type="text" placeholder="Prénom" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Marque / Type</label>
                                <input class="form-control" name="brand" type="text" placeholder="Marque" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Immatriculation</label>
                                <input class="form-control" name="matricule" type="text" placeholder="Matricule"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Contact</label>
                                <input class="form-control" name="contact" type="tel" placeholder="Contact" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Assurance</label>
                                <input class="form-control" name="name" type="text" placeholder="Assurance"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Tiers</label>
                                <input class="form-control" name="tiers" type="text" placeholder="Tiers"
                                    required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Date d'ouverture</label>
                                <input class="form-control" name="date_open" type="date"
                                    placeholder="Date d'ouverture" required />
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

    @foreach ($sinistres as $sinistre)
        <div class="modal fade" id="cardModal{{ $sinistre->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabelOne" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour le sinistre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <form action="{{ url('admin/sinistre/' . $sinistre->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Nom Complet</label>
                                    <input class="form-control" name="name" type="text" placeholder="Nom Complet"
                                        value="{{ $sinistre->name }}" required />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Nom</label>
                                    <input class="form-control" name="lastname" type="text" placeholder="Nom"
                                        value="{{ $sinistre->lastname }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Prénom</label>
                                    <input class="form-control" name="firstname" type="text" placeholder="Prénom"
                                        value="{{ $sinistre->firstname }}" required />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Marque / Type</label>
                                    <input class="form-control" name="brand" type="text" placeholder="Marque"
                                        value="{{ $sinistre->brand }}" required />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Immatriculation</label>
                                    <input class="form-control" name="matricule" type="text" placeholder="Matricule"
                                        value="{{ $sinistre->matricule }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Contact</label>
                                    <input class="form-control" name="contact" type="tel" placeholder="Contact"
                                        value="{{ $sinistre->contact }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Assurance</label>
                                    <input class="form-control" name="name" type="text" placeholder="Assurance"
                                        value="{{ $sinistre->assurance }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Tiers</label>
                                    <input class="form-control" name="tiers" type="text" placeholder="Tiers"
                                        value="{{ $sinistre->tiers }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Date d'ouverture</label>
                                    <input class="form-control" name="date_open" type="date"
                                        placeholder="Date d'ouverture" value="{{ $sinistre->date_open }}" required />
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
    @endforeach

    @foreach ($sinistres as $sinistre)
        <!-- Modal -->
        <div class="modal fade" id="cardModalCenter{{ $sinistre->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer ce sinistre ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        <form method="POST" action="{{ url('admin/sinistre/' . $sinistre->id) }}">
                            @csrf
                            <input type="hidden" name="delete" value="true">
                            <button class="btn btn-danger" style="background-color: #D50100 !important;"
                                type="submit"><i class="me-2 icon-xxs dropdown-item-icon"
                                    data-feather="trash-2"></i>Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
