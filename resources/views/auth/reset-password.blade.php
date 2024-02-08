@extends('layout.login')

@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset('media/auth/bg4-dark.jpg') }}');
            }

            [data-bs-theme="dark"] body {
                background-image: url('{{ asset('media/auth/bg4-dark.jpg') }}');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-column flex-center  h-lg-80 rounded-4 w-md-600px">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column align-items-stretch h-lg-80 w-md-400px">
                        <!--begin::Form-->
                        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                            <!--begin::Wrapper-->
                            <div class="w-lg-500px p-10">
                                <!--begin::Form-->
                                <form class="form w-100" method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <!--begin::Heading-->
                                    <div class="text-center mb-11">
                                        <!--begin::Title-->
                                        <a href="{{ url('/') }}">
                                            <img style="margin-right: 10px;" width="30%"
                                                src="{{ asset('media/logos/logo_eaceia.png') }}" class="header-logo__image"
                                                alt="Exa Conseil">
                                        </a>
                                        <!--end::Title-->
                                    </div>
                                    <!--begin::Heading-->

                                    @include('layout.alert')

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Email-->
                                        <input type="text" placeholder="Email" name="email" value="{{ old('email') }}"
                                            autocomplete="off" class="form-control bg-transparent" />
                                        <!--end::Email-->
                                        @if ($errors->has('email'))
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                {{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::Password-->
                                        <input type="password" placeholder="Mot de passe" name="password" autocomplete="off"
                                            class="form-control bg-transparent" />
                                        <!--end::Password-->
                                        @if ($errors->has('password'))
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                {{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Input group=-->

                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::Password-->
                                        <input type="password" id="password-confirm" placeholder="Confirmer le Mot de passe"
                                            name="password_confirmation" autocomplete="off"
                                            class="form-control bg-transparent" />
                                        <!--end::Password-->
                                        @if ($errors->has('password_confirmation'))
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                {{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                    <!--end::Input group=-->

                                    <!--begin::Submit button-->
                                    <div class="d-grid mb-10">
                                        <button type="submit" class="btn btn-primary">
                                            <!--begin::Indicator label-->
                                            <span class="indicator-label">Réinitialiser</span>
                                            <!--end::Indicator label-->
                                        </button>
                                    </div>
                                    <!--end::Submit button-->

                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Form-->
                        <!--begin::Footer-->
                        <div class=" d-flex flex-center px-10 mx-auto">

                            <!--begin::Links-->
                            <div class="d-flex fw-semibold text-black mb-10 fs-base ">
                                <p>{{ date('Y') }} © Exa Conseil</p>
                            </div>
                            <!--end::Links-->
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid">
                <!--begin::Content-->

                <!--end::Content-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
@endsection
