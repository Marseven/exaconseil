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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Utilisateur</h1>
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
                        <li class="breadcrumb-item text-muted">Gestion des utilisateurs</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Liste des utilisateurs</li>
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
                            <h2>Liste des Utilisateurs</h2>
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
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Poste</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->lastname . ' ' . $admin->firstname }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>{{ $admin->poste }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#cardModal{{ $admin->id }}">Modifier</button>
                                            <button class="btn btn-xs btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#cardModalCenter{{ $admin->id }}">
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
                    <h5 class="modal-title" id="exampleModalLabelOne">Ajouter un agent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/create/user/') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Nom</label>
                                <input class="form-control" name="lastname" type="text" placeholder="Nom"
                                    value="{{ $admin->name }}" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Prénom</label>
                                <input class="form-control" name="firstname" type="text" placeholder="Prénom"
                                    value="{{ $admin->name }}" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Email</label>
                                <input class="form-control" name="email" type="email" placeholder="Email"
                                    value="{{ $admin->email }}" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Téléphone</label>
                                <input class="form-control" name="phone" type="tel" placeholder="Téléphone" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-style-1">
                                <label>Poste</label>
                                <input class="form-control" name="poste" type="text" placeholder="Poste" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Entreprise</label>
                            <select target="responsable" id="entreprise" class="form-control linked-select"
                                name="entreprise_id">
                                @foreach ($entreprises as $entreprise)
                                    <option value="{{ $entreprise->id }}">{{ $entreprise->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Responsable</label>
                            <select id="responsable" class="form-control" name="responsable_id">
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Rôle</label>
                            <select id="selectOne" class="form-control" name="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}
                                    </option>
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

    @foreach ($admins as $admin)
        <div class="modal fade" id="cardModal{{ $admin->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabelOne" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelOne">Mettre à jour l'utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="lni lni-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('admin/user/' . $admin->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Nom</label>
                                    <input class="form-control" name="lastname" type="text" placeholder="Nom"
                                        value="{{ $admin->lastname }}" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Prénom</label>
                                    <input class="form-control" name="firstname" type="text" placeholder="Prénom"
                                        value="{{ $admin->firstname }}" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Email</label>
                                    <input class="form-control" name="email" type="email" placeholder="Email"
                                        value="{{ $admin->email }}" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Téléphone</label>
                                    <input class="form-control" name="phone" type="tel" placeholder="Téléphone"
                                        value="{{ $admin->phone }}" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-style-1">
                                    <label>Poste</label>
                                    <input class="form-control" name="poste" type="text"
                                        value="{{ $admin->poste }}" placeholder="Poste" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Responsable</label>
                                <select class="form-control" name="responsable_id">
                                    @foreach ($admins as $ad)
                                        @if ($admin->entreprise_id == $ad->entreprise_id && $admin->id != $ad->id)
                                            <option value="{{ $ad->id }}">
                                                {{ $ad->lastname . ' ' . $ad->firstname }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Rôle</label>
                                <select id="selectOne" class="form-control" name="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
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
    @endforeach

    @foreach ($admins as $admin)
        <!-- Modal -->
        <div class="modal fade" id="cardModalCenter{{ $admin->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer cet administrateur ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        <form method="POST" action="{{ url('admin/update-user/' . $admin->id) }}">
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

        $(".linked-select").change(function() {
            var id = $(this).val();
            var target = $(this).attr('target');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery(
                            'meta[name="csrf-token"]')
                        .attr('content')
                },
                url: "{{ route('admin-select') }}",
                data: {
                    'id': id,
                },
                method: 'POST',
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    result = JSON.parse(result);
                    var option_html = "<option value='-1'>Choisir</option>";

                    for (i = 0; i < result.length; i++) {
                        is_selected = $("#" + target).data('val') == result[i].id ? 'selected' : '';
                        option_html += "<option " + is_selected + "  value='" + result[i].id +
                            "'>" +
                            result[i].lastname + " " +
                            result[i].firstname +
                            "</option>";
                    }

                    $("#" + target).html(option_html);
                    $("#" + target).change();
                }
            });
        });

        $(".linked-select").change();
    </script>
@endpush
