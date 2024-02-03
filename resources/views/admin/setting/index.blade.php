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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Paramètres</h1>
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
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Paramètres</li>
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

                @foreach ($entreprises as $entreprise)
                    <form method="POST" action="{{ route('admin-save-settings') }}">
                        <div class="card mb-5 mb-xl-10">
                            <!--begin::Card header-->
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_account_connected_accounts" aria-expanded="true"
                                aria-controls="kt_account_connected_accounts">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">{{ $entreprise->company_name }}</h3>
                                    @csrf
                                    <input type="hidden" name="entreprise_id" value="{{ $entreprise->id }}" />
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Content-->
                            <div id="kt_account_settings_connected_accounts" class="collapse show">
                                <!--begin::Card body-->
                                <div class="card-body border-top p-9">

                                    <!--begin::Items-->
                                    <div class="py-2">
                                        @foreach ($services as $service)
                                            <!--begin::Item-->
                                            <div class="d-flex flex-stack">
                                                <div class="d-flex">
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="fs-5 text-dark text-hover-primary fw-bold">{{ $service->name }}</a>
                                                        <div class="fs-6 fw-semibold text-gray-400">
                                                            {{ $service->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="form-check form-check-solid form-check-custom form-switch">
                                                        <input class="form-check-input w-45px h-30px" type="checkbox"
                                                            name="services[]" value="{{ $service->id }}"
                                                            @if ($entreprise->services->contains($service->id)) checked @endif>
                                                        <label class="form-check-label" for="services"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                        @endforeach

                                        <div class="separator separator-dashed my-5"></div>

                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Card body-->
                                <!--begin::Card footer-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                                <!--end::Card footer-->
                            </div>
                            <!--end::Content-->
                        </div>
                    </form>
                @endforeach



            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
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
