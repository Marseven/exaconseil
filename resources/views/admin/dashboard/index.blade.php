@extends('layout.default')

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
                    <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Tableau de Bord</h1>
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

                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xl-3">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                            style="background-color: #F1416C;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                            <!--begin::Header-->
                            <div class="card-header pt-5 mb-3">
                                <!--begin::Icon-->
                                <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                    style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
                                    <i class="ki-outline ki-wallet text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="fs-4hx text-white fw-bold me-6">{{ $cashflows }}</span>
                                    <div class="fw-bold fs-6 text-white">
                                        <span class="d-block">Transactions</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer"
                                style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                                <!--begin::Progress-->
                                <div class="fw-bold text-white py-2">
                                    <span class="fs-1 d-block">{{ $cashflows_credit }}</span>
                                    <span class="opacity-50">Transactions Crédits</span>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->

                    @if ($user->entreprise_id == 1)
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <!--begin::Card widget 3-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                                style="background-color: #7239EA;background-image:url('assets/media/svg/shapes/wave-bg-purple.svg')">
                                <!--begin::Header-->
                                <div class="card-header pt-5 mb-3">
                                    <!--begin::Icon-->
                                    <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                        style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA">
                                        <i class="ki-outline ki-wallet text-white fs-2qx lh-0"></i>
                                    </div>
                                    <!--end::Icon-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end mb-3">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <span class="fs-4hx text-white fw-bold me-6">{{ $factures }}</span>
                                        <div class="fw-bold fs-6 text-white">
                                            <span class="d-block">Factures</span>
                                        </div>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Card body-->
                                <!--begin::Card footer-->
                                <div class="card-footer"
                                    style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                                    <!--begin::Progress-->
                                    <div class="fw-bold text-white py-2">
                                        <span class="fs-1 d-block">{{ $factures_paid }}</span>
                                        <span class="opacity-50">Factures Payées</span>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card footer-->
                            </div>
                            <!--end::Card widget 3-->
                        </div>
                        <!--end::Col-->
                    @endif

                    @if ($user->entreprise_id == 2)
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <!--begin::Card widget 3-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100"
                                style="background-color: #7239EA;background-image:url('assets/media/svg/shapes/wave-bg-purple.svg')">
                                <!--begin::Header-->
                                <div class="card-header pt-5 mb-3">
                                    <!--begin::Icon-->
                                    <div class="d-flex flex-center rounded-circle h-80px w-80px"
                                        style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA">
                                        <i class="ki-outline ki-address-book text-white fs-2qx lh-0"></i>
                                    </div>
                                    <!--end::Icon-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end mb-3">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <span class="fs-4hx text-white fw-bold me-6">{{ $policies }}</span>
                                        <div class="fw-bold fs-6 text-white">
                                            <span class="d-block">Polices</span>
                                        </div>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Card body-->
                                <!--begin::Card footer-->
                                <div class="card-footer"
                                    style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                                    <!--begin::Progress-->
                                    <div class="fw-bold text-white py-2">
                                        <span class="fs-1 d-block">{{ $policies_exp }}</span>
                                        <span class="opacity-50">Police Expirée</span>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card footer-->
                            </div>
                            <!--end::Card widget 3-->
                        </div>
                        <!--end::Col-->
                    @endif

                    <!--begin::Col-->
                    <div class="col-xl-6">
                        <!--begin::Chart widget 36-->
                        <div class="card card-flush overflow-hidden h-lg-100">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Tendances de transaction</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                                </h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                        data-kt-daterangepicker-range="today"
                                        class="btn btn-sm btn-light d-flex align-items-center px-4" data-kt-initialized="1">
                                        <!--begin::Display range-->
                                        <div class="text-gray-600 fw-bold">{{ date('d M. Y') }}</div>
                                        <!--end::Display range-->
                                        <i class="ki-outline ki-calendar-8 fs-1 ms-2 me-0"></i>
                                    </div>
                                    <!--end::Daterangepicker-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end p-0">
                                <!--begin::Chart-->
                                <div id="kt_charts_widget_36" class="min-h-auto w-100 ps-4 pe-6" style="height: 300px">
                                </div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Chart widget 36-->
                    </div>
                    <!--end::Col-->
                </div>

                @if ($role && ($role->name == 'Gerant' || $role->name == 'SuperAdmin'))
                    <!--begin::Row-->
                    <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <!--begin::Card widget 20-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10"
                                style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div
                                            class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>43 Pending</span>
                                            <span>72%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 20-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <!--begin::Card widget 20-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10"
                                style="background-color: #FF8A00;background-image:url('assets/media/patterns/vector-1.png')">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div
                                            class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>43 Pending</span>
                                            <span>72%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 20-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <!--begin::Card widget 20-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10"
                                style="background-color: #008000;background-image:url('assets/media/patterns/vector-1.png')">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div
                                            class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>43 Pending</span>
                                            <span>72%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 20-->

                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <!--begin::Card widget 20-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10"
                                style="background-color: #009ef7;background-image:url('assets/media/patterns/vector-1.png')">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Projects</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div
                                            class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>43 Pending</span>
                                            <span>72%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 20-->

                        </div>
                        <!--end::Col-->


                    </div>
                    <!--end::Row-->
                @endif

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection
