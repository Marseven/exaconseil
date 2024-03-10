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

                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection
