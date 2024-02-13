@extends('layout.default')

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
                                    <i class="ki-outline ki-call text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="fs-4hx text-white fw-bold me-6">1.2k</span>
                                    <div class="fw-bold fs-6 text-white">
                                        <span class="d-block">Inbound</span>
                                        <span class="">Calls</span>
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
                                    <span class="fs-1 d-block">935</span>
                                    <span class="opacity-50">Problems Solved</span>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
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
                                    <i class="ki-outline ki-call text-white fs-2qx lh-0"></i>
                                </div>
                                <!--end::Icon-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="fs-4hx text-white fw-bold me-6">427</span>
                                    <div class="fw-bold fs-6 text-white">
                                        <span class="d-block">Outbound</span>
                                        <span class="">Calls</span>
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
                                    <span class="fs-1 d-block">386</span>
                                    <span class="opacity-50">Generated Leads</span>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-6">
                        <!--begin::Chart widget 36-->
                        <div class="card card-flush overflow-hidden h-lg-100">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">Performance</span>
                                    <span class="text-gray-400 mt-1 fw-semibold fs-6">1,046 Inbound Calls today</span>
                                </h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                        data-kt-daterangepicker-range="today"
                                        class="btn btn-sm btn-light d-flex align-items-center px-4" data-kt-initialized="1">
                                        <!--begin::Display range-->
                                        <div class="text-gray-600 fw-bold">13 févr. 2024</div>
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
                                <div id="kt_charts_widget_36" class="min-h-auto w-100 ps-4 pe-6"
                                    style="height: 300px; min-height: 315px;">
                                    <div id="apexchartsjlt6muop"
                                        class="apexcharts-canvas apexchartsjlt6muop apexcharts-theme-light"
                                        style="width: 581.5px; height: 300px;"><svg id="SvgjsSvg1717" width="581.5"
                                            height="300" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                                            class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS"
                                            transform="translate(0, 0)" style="background: transparent;">
                                            <foreignObject x="0" y="0" width="581.5" height="300">
                                                <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"
                                                    style="max-height: 150px;"></div>
                                            </foreignObject>
                                            <rect id="SvgjsRect1757" width="0" height="0" x="0" y="0"
                                                rx="0" ry="0" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
                                            <g id="SvgjsG1820" class="apexcharts-yaxis" rel="0"
                                                transform="translate(17.3359375, 0)">
                                                <g id="SvgjsG1821" class="apexcharts-yaxis-texts-g"><text
                                                        id="SvgjsText1823" font-family="inherit" x="20" y="31.6"
                                                        text-anchor="end" dominant-baseline="auto" font-size="12px"
                                                        font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1824">120</tspan>
                                                        <title>120</title>
                                                    </text><text id="SvgjsText1826" font-family="inherit" x="20"
                                                        y="68.65988888888887" text-anchor="end" dominant-baseline="auto"
                                                        font-size="12px" font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1827">105</tspan>
                                                        <title>105</title>
                                                    </text><text id="SvgjsText1829" font-family="inherit" x="20"
                                                        y="105.71977777777775" text-anchor="end" dominant-baseline="auto"
                                                        font-size="12px" font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1830">90</tspan>
                                                        <title>90</title>
                                                    </text><text id="SvgjsText1832" font-family="inherit" x="20"
                                                        y="142.77966666666663" text-anchor="end" dominant-baseline="auto"
                                                        font-size="12px" font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1833">75</tspan>
                                                        <title>75</title>
                                                    </text><text id="SvgjsText1835" font-family="inherit" x="20"
                                                        y="179.8395555555555" text-anchor="end" dominant-baseline="auto"
                                                        font-size="12px" font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1836">60</tspan>
                                                        <title>60</title>
                                                    </text><text id="SvgjsText1838" font-family="inherit" x="20"
                                                        y="216.89944444444438" text-anchor="end" dominant-baseline="auto"
                                                        font-size="12px" font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1839">45</tspan>
                                                        <title>45</title>
                                                    </text><text id="SvgjsText1841" font-family="inherit" x="20"
                                                        y="253.95933333333326" text-anchor="end" dominant-baseline="auto"
                                                        font-size="12px" font-weight="400" fill="#99a1b7"
                                                        class="apexcharts-text apexcharts-yaxis-label "
                                                        style="font-family: inherit;">
                                                        <tspan id="SvgjsTspan1842">30</tspan>
                                                        <title>30</title>
                                                    </text></g>
                                            </g>
                                            <g id="SvgjsG1719" class="apexcharts-inner apexcharts-graphical"
                                                transform="translate(47.3359375, 30)">
                                                <defs id="SvgjsDefs1718">
                                                    <clipPath id="gridRectMaskjlt6muop">
                                                        <rect id="SvgjsRect1723" width="531.1640625"
                                                            height="225.35933333333332" x="-3.5" y="-1.5" rx="0"
                                                            ry="0" opacity="1" stroke-width="0"
                                                            stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                    </clipPath>
                                                    <clipPath id="forecastMaskjlt6muop"></clipPath>
                                                    <clipPath id="nonForecastMaskjlt6muop"></clipPath>
                                                    <clipPath id="gridRectMarkerMaskjlt6muop">
                                                        <rect id="SvgjsRect1724" width="528.1640625"
                                                            height="226.35933333333332" x="-2" y="-2" rx="0"
                                                            ry="0" opacity="1" stroke-width="0"
                                                            stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                    </clipPath>
                                                    <linearGradient id="SvgjsLinearGradient1729" x1="0"
                                                        y1="0" x2="0" y2="1">
                                                        <stop id="SvgjsStop1730" stop-opacity="0.4"
                                                            stop-color="rgba(0,158,247,0.4)" offset="0.15"></stop>
                                                        <stop id="SvgjsStop1731" stop-opacity="0.2"
                                                            stop-color="rgba(255,255,255,0.2)" offset="1.2"></stop>
                                                        <stop id="SvgjsStop1732" stop-opacity="0.2"
                                                            stop-color="rgba(255,255,255,0.2)" offset="1"></stop>
                                                    </linearGradient>
                                                    <linearGradient id="SvgjsLinearGradient1738" x1="0"
                                                        y1="0" x2="0" y2="1">
                                                        <stop id="SvgjsStop1739" stop-opacity="0.4"
                                                            stop-color="rgba(80,205,137,0.4)" offset="0.15"></stop>
                                                        <stop id="SvgjsStop1740" stop-opacity="0.2"
                                                            stop-color="rgba(255,255,255,0.2)" offset="1.2"></stop>
                                                        <stop id="SvgjsStop1741" stop-opacity="0.2"
                                                            stop-color="rgba(255,255,255,0.2)" offset="1"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <g id="SvgjsG1744" class="apexcharts-grid">
                                                    <g id="SvgjsG1745" class="apexcharts-gridlines-horizontal">
                                                        <line id="SvgjsLine1749" x1="0" y1="37.059888888888885"
                                                            x2="524.1640625" y2="37.059888888888885" stroke="#dbdfe9"
                                                            stroke-dasharray="4" stroke-linecap="butt"
                                                            class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1750" x1="0" y1="74.11977777777777"
                                                            x2="524.1640625" y2="74.11977777777777" stroke="#dbdfe9"
                                                            stroke-dasharray="4" stroke-linecap="butt"
                                                            class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1751" x1="0" y1="111.17966666666666"
                                                            x2="524.1640625" y2="111.17966666666666" stroke="#dbdfe9"
                                                            stroke-dasharray="4" stroke-linecap="butt"
                                                            class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1752" x1="0" y1="148.23955555555554"
                                                            x2="524.1640625" y2="148.23955555555554" stroke="#dbdfe9"
                                                            stroke-dasharray="4" stroke-linecap="butt"
                                                            class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1753" x1="0" y1="185.29944444444442"
                                                            x2="524.1640625" y2="185.29944444444442" stroke="#dbdfe9"
                                                            stroke-dasharray="4" stroke-linecap="butt"
                                                            class="apexcharts-gridline"></line>
                                                        <line id="SvgjsLine1754" x1="0" y1="222.3593333333333"
                                                            x2="524.1640625" y2="222.3593333333333" stroke="#dbdfe9"
                                                            stroke-dasharray="4" stroke-linecap="butt"
                                                            class="apexcharts-gridline"></line>
                                                    </g>
                                                    <g id="SvgjsG1746" class="apexcharts-gridlines-vertical"></g>
                                                    <line id="SvgjsLine1756" x1="0" y1="222.35933333333332"
                                                        x2="524.1640625" y2="222.35933333333332" stroke="transparent"
                                                        stroke-dasharray="0" stroke-linecap="butt"></line>
                                                    <line id="SvgjsLine1755" x1="0" y1="1"
                                                        x2="0" y2="222.35933333333332" stroke="transparent"
                                                        stroke-dasharray="0" stroke-linecap="butt"></line>
                                                </g>
                                                <g id="SvgjsG1725" class="apexcharts-area-series apexcharts-plot-series">
                                                    <g id="SvgjsG1726" class="apexcharts-series"
                                                        seriesName="InboundxCalls" data:longestSeries="true"
                                                        rel="1" data:realIndex="0">
                                                        <path id="SvgjsPath1733"
                                                            d="M 0 222.35933333333332 L 0 135.88625925925925C 10.192078993055555 135.88625925925925 18.92814670138889 98.82637037037034 29.120225694444443 98.82637037037034C 39.312304687499996 98.82637037037034 48.04837239583333 98.82637037037034 58.240451388888886 98.82637037037034C 68.43253038194445 98.82637037037034 77.16859809027777 148.23955555555554 87.36067708333333 148.23955555555554C 97.55275607638889 148.23955555555554 106.28882378472221 148.23955555555554 116.48090277777777 148.23955555555554C 126.67298177083332 148.23955555555554 135.40904947916664 185.29944444444442 145.6011284722222 185.29944444444442C 155.79320746527776 185.29944444444442 164.5292751736111 185.29944444444442 174.72135416666666 185.29944444444442C 184.91343315972222 185.29944444444442 193.64950086805553 98.82637037037034 203.8415798611111 98.82637037037034C 214.03365885416665 98.82637037037034 222.76972656249998 98.82637037037034 232.96180555555554 98.82637037037034C 243.1538845486111 98.82637037037034 251.88995225694444 123.53296296296296 262.08203125 123.53296296296296C 272.27411024305553 123.53296296296296 281.01017795138887 123.53296296296296 291.2022569444444 123.53296296296296C 301.39433593749993 123.53296296296296 310.1304036458333 74.11977777777776 320.32248263888886 74.11977777777776C 330.5145616319444 74.11977777777776 339.2506293402778 74.11977777777776 349.4427083333333 74.11977777777776C 359.63478732638885 74.11977777777776 368.37085503472224 98.82637037037034 378.56293402777777 98.82637037037034C 388.7550130208333 98.82637037037034 397.49108072916664 98.82637037037034 407.6831597222222 98.82637037037034C 417.87523871527776 98.82637037037034 426.61130642361104 98.82637037037034 436.80338541666663 98.82637037037034C 446.9954644097222 98.82637037037034 455.7315321180555 148.23955555555554 465.9236111111111 148.23955555555554C 476.1156901041666 148.23955555555554 484.85175781249995 148.23955555555554 495.0438368055555 148.23955555555554C 505.2359157986111 148.23955555555554 513.9719835069444 172.94614814814813 524.1640625 172.94614814814813C 524.1640625 172.94614814814813 524.1640625 172.94614814814813 524.1640625 222.35933333333332M 524.1640625 172.94614814814813z"
                                                            fill="url(#SvgjsLinearGradient1729)" fill-opacity="1"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="0"
                                                            stroke-dasharray="0" class="apexcharts-area" index="0"
                                                            clip-path="url(#gridRectMaskjlt6muop)"
                                                            pathTo="M 0 222.35933333333332 L 0 135.88625925925925C 10.192078993055555 135.88625925925925 18.92814670138889 98.82637037037034 29.120225694444443 98.82637037037034C 39.312304687499996 98.82637037037034 48.04837239583333 98.82637037037034 58.240451388888886 98.82637037037034C 68.43253038194445 98.82637037037034 77.16859809027777 148.23955555555554 87.36067708333333 148.23955555555554C 97.55275607638889 148.23955555555554 106.28882378472221 148.23955555555554 116.48090277777777 148.23955555555554C 126.67298177083332 148.23955555555554 135.40904947916664 185.29944444444442 145.6011284722222 185.29944444444442C 155.79320746527776 185.29944444444442 164.5292751736111 185.29944444444442 174.72135416666666 185.29944444444442C 184.91343315972222 185.29944444444442 193.64950086805553 98.82637037037034 203.8415798611111 98.82637037037034C 214.03365885416665 98.82637037037034 222.76972656249998 98.82637037037034 232.96180555555554 98.82637037037034C 243.1538845486111 98.82637037037034 251.88995225694444 123.53296296296296 262.08203125 123.53296296296296C 272.27411024305553 123.53296296296296 281.01017795138887 123.53296296296296 291.2022569444444 123.53296296296296C 301.39433593749993 123.53296296296296 310.1304036458333 74.11977777777776 320.32248263888886 74.11977777777776C 330.5145616319444 74.11977777777776 339.2506293402778 74.11977777777776 349.4427083333333 74.11977777777776C 359.63478732638885 74.11977777777776 368.37085503472224 98.82637037037034 378.56293402777777 98.82637037037034C 388.7550130208333 98.82637037037034 397.49108072916664 98.82637037037034 407.6831597222222 98.82637037037034C 417.87523871527776 98.82637037037034 426.61130642361104 98.82637037037034 436.80338541666663 98.82637037037034C 446.9954644097222 98.82637037037034 455.7315321180555 148.23955555555554 465.9236111111111 148.23955555555554C 476.1156901041666 148.23955555555554 484.85175781249995 148.23955555555554 495.0438368055555 148.23955555555554C 505.2359157986111 148.23955555555554 513.9719835069444 172.94614814814813 524.1640625 172.94614814814813C 524.1640625 172.94614814814813 524.1640625 172.94614814814813 524.1640625 222.35933333333332M 524.1640625 172.94614814814813z"
                                                            pathFrom="M -1 296.4791111111111 L -1 296.4791111111111 L 29.120225694444443 296.4791111111111 L 58.240451388888886 296.4791111111111 L 87.36067708333333 296.4791111111111 L 116.48090277777777 296.4791111111111 L 145.6011284722222 296.4791111111111 L 174.72135416666666 296.4791111111111 L 203.8415798611111 296.4791111111111 L 232.96180555555554 296.4791111111111 L 262.08203125 296.4791111111111 L 291.2022569444444 296.4791111111111 L 320.32248263888886 296.4791111111111 L 349.4427083333333 296.4791111111111 L 378.56293402777777 296.4791111111111 L 407.6831597222222 296.4791111111111 L 436.80338541666663 296.4791111111111 L 465.9236111111111 296.4791111111111 L 495.0438368055555 296.4791111111111 L 524.1640625 296.4791111111111">
                                                        </path>
                                                        <path id="SvgjsPath1734"
                                                            d="M 0 135.88625925925925C 10.192078993055555 135.88625925925925 18.92814670138889 98.82637037037034 29.120225694444443 98.82637037037034C 39.312304687499996 98.82637037037034 48.04837239583333 98.82637037037034 58.240451388888886 98.82637037037034C 68.43253038194445 98.82637037037034 77.16859809027777 148.23955555555554 87.36067708333333 148.23955555555554C 97.55275607638889 148.23955555555554 106.28882378472221 148.23955555555554 116.48090277777777 148.23955555555554C 126.67298177083332 148.23955555555554 135.40904947916664 185.29944444444442 145.6011284722222 185.29944444444442C 155.79320746527776 185.29944444444442 164.5292751736111 185.29944444444442 174.72135416666666 185.29944444444442C 184.91343315972222 185.29944444444442 193.64950086805553 98.82637037037034 203.8415798611111 98.82637037037034C 214.03365885416665 98.82637037037034 222.76972656249998 98.82637037037034 232.96180555555554 98.82637037037034C 243.1538845486111 98.82637037037034 251.88995225694444 123.53296296296296 262.08203125 123.53296296296296C 272.27411024305553 123.53296296296296 281.01017795138887 123.53296296296296 291.2022569444444 123.53296296296296C 301.39433593749993 123.53296296296296 310.1304036458333 74.11977777777776 320.32248263888886 74.11977777777776C 330.5145616319444 74.11977777777776 339.2506293402778 74.11977777777776 349.4427083333333 74.11977777777776C 359.63478732638885 74.11977777777776 368.37085503472224 98.82637037037034 378.56293402777777 98.82637037037034C 388.7550130208333 98.82637037037034 397.49108072916664 98.82637037037034 407.6831597222222 98.82637037037034C 417.87523871527776 98.82637037037034 426.61130642361104 98.82637037037034 436.80338541666663 98.82637037037034C 446.9954644097222 98.82637037037034 455.7315321180555 148.23955555555554 465.9236111111111 148.23955555555554C 476.1156901041666 148.23955555555554 484.85175781249995 148.23955555555554 495.0438368055555 148.23955555555554C 505.2359157986111 148.23955555555554 513.9719835069444 172.94614814814813 524.1640625 172.94614814814813"
                                                            fill="none" fill-opacity="1" stroke="#009ef7"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                            stroke-dasharray="0" class="apexcharts-area" index="0"
                                                            clip-path="url(#gridRectMaskjlt6muop)"
                                                            pathTo="M 0 135.88625925925925C 10.192078993055555 135.88625925925925 18.92814670138889 98.82637037037034 29.120225694444443 98.82637037037034C 39.312304687499996 98.82637037037034 48.04837239583333 98.82637037037034 58.240451388888886 98.82637037037034C 68.43253038194445 98.82637037037034 77.16859809027777 148.23955555555554 87.36067708333333 148.23955555555554C 97.55275607638889 148.23955555555554 106.28882378472221 148.23955555555554 116.48090277777777 148.23955555555554C 126.67298177083332 148.23955555555554 135.40904947916664 185.29944444444442 145.6011284722222 185.29944444444442C 155.79320746527776 185.29944444444442 164.5292751736111 185.29944444444442 174.72135416666666 185.29944444444442C 184.91343315972222 185.29944444444442 193.64950086805553 98.82637037037034 203.8415798611111 98.82637037037034C 214.03365885416665 98.82637037037034 222.76972656249998 98.82637037037034 232.96180555555554 98.82637037037034C 243.1538845486111 98.82637037037034 251.88995225694444 123.53296296296296 262.08203125 123.53296296296296C 272.27411024305553 123.53296296296296 281.01017795138887 123.53296296296296 291.2022569444444 123.53296296296296C 301.39433593749993 123.53296296296296 310.1304036458333 74.11977777777776 320.32248263888886 74.11977777777776C 330.5145616319444 74.11977777777776 339.2506293402778 74.11977777777776 349.4427083333333 74.11977777777776C 359.63478732638885 74.11977777777776 368.37085503472224 98.82637037037034 378.56293402777777 98.82637037037034C 388.7550130208333 98.82637037037034 397.49108072916664 98.82637037037034 407.6831597222222 98.82637037037034C 417.87523871527776 98.82637037037034 426.61130642361104 98.82637037037034 436.80338541666663 98.82637037037034C 446.9954644097222 98.82637037037034 455.7315321180555 148.23955555555554 465.9236111111111 148.23955555555554C 476.1156901041666 148.23955555555554 484.85175781249995 148.23955555555554 495.0438368055555 148.23955555555554C 505.2359157986111 148.23955555555554 513.9719835069444 172.94614814814813 524.1640625 172.94614814814813"
                                                            pathFrom="M -1 296.4791111111111 L -1 296.4791111111111 L 29.120225694444443 296.4791111111111 L 58.240451388888886 296.4791111111111 L 87.36067708333333 296.4791111111111 L 116.48090277777777 296.4791111111111 L 145.6011284722222 296.4791111111111 L 174.72135416666666 296.4791111111111 L 203.8415798611111 296.4791111111111 L 232.96180555555554 296.4791111111111 L 262.08203125 296.4791111111111 L 291.2022569444444 296.4791111111111 L 320.32248263888886 296.4791111111111 L 349.4427083333333 296.4791111111111 L 378.56293402777777 296.4791111111111 L 407.6831597222222 296.4791111111111 L 436.80338541666663 296.4791111111111 L 465.9236111111111 296.4791111111111 L 495.0438368055555 296.4791111111111 L 524.1640625 296.4791111111111"
                                                            fill-rule="evenodd"></path>
                                                        <g id="SvgjsG1727"
                                                            class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                                            data:realIndex="0">
                                                            <g class="apexcharts-series-markers">
                                                                <circle id="SvgjsCircle1846" r="0" cx="0"
                                                                    cy="0"
                                                                    class="apexcharts-marker woibhryv5 no-pointer-events"
                                                                    stroke="#009ef7" fill="#009ef7" fill-opacity="1"
                                                                    stroke-width="3" stroke-opacity="0.9"
                                                                    default-marker-size="0"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1735" class="apexcharts-series"
                                                        seriesName="OutboundxCalls" data:longestSeries="true"
                                                        rel="2" data:realIndex="1">
                                                        <path id="SvgjsPath1742"
                                                            d="M 0 222.35933333333332 L 0 74.11977777777776C 10.192078993055555 74.11977777777776 18.92814670138889 24.706592592592585 29.120225694444443 24.706592592592585C 39.312304687499996 24.706592592592585 48.04837239583333 24.706592592592585 58.240451388888886 24.706592592592585C 68.43253038194445 24.706592592592585 77.16859809027777 61.76648148148146 87.36067708333333 61.76648148148146C 97.55275607638889 61.76648148148146 106.28882378472221 61.76648148148146 116.48090277777777 61.76648148148146C 126.67298177083332 61.76648148148146 135.40904947916664 86.47307407407405 145.6011284722222 86.47307407407405C 155.79320746527776 86.47307407407405 164.5292751736111 86.47307407407405 174.72135416666666 86.47307407407405C 184.91343315972222 86.47307407407405 193.64950086805553 61.76648148148146 203.8415798611111 61.76648148148146C 214.03365885416665 61.76648148148146 222.76972656249998 61.76648148148146 232.96180555555554 61.76648148148146C 243.1538845486111 61.76648148148146 251.88995225694444 12.353296296296264 262.08203125 12.353296296296264C 272.27411024305553 12.353296296296264 281.01017795138887 12.353296296296264 291.2022569444444 12.353296296296264C 301.39433593749993 12.353296296296264 310.1304036458333 49.41318518518517 320.32248263888886 49.41318518518517C 330.5145616319444 49.41318518518517 339.2506293402778 49.41318518518517 349.4427083333333 49.41318518518517C 359.63478732638885 49.41318518518517 368.37085503472224 12.353296296296264 378.56293402777777 12.353296296296264C 388.7550130208333 12.353296296296264 397.49108072916664 12.353296296296264 407.6831597222222 12.353296296296264C 417.87523871527776 12.353296296296264 426.61130642361104 61.76648148148146 436.80338541666663 61.76648148148146C 446.9954644097222 61.76648148148146 455.7315321180555 61.76648148148146 465.9236111111111 61.76648148148146C 476.1156901041666 61.76648148148146 484.85175781249995 86.47307407407405 495.0438368055555 86.47307407407405C 505.2359157986111 86.47307407407405 513.9719835069444 86.47307407407405 524.1640625 86.47307407407405C 524.1640625 86.47307407407405 524.1640625 86.47307407407405 524.1640625 222.35933333333332M 524.1640625 86.47307407407405z"
                                                            fill="url(#SvgjsLinearGradient1738)" fill-opacity="1"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="0"
                                                            stroke-dasharray="0" class="apexcharts-area" index="1"
                                                            clip-path="url(#gridRectMaskjlt6muop)"
                                                            pathTo="M 0 222.35933333333332 L 0 74.11977777777776C 10.192078993055555 74.11977777777776 18.92814670138889 24.706592592592585 29.120225694444443 24.706592592592585C 39.312304687499996 24.706592592592585 48.04837239583333 24.706592592592585 58.240451388888886 24.706592592592585C 68.43253038194445 24.706592592592585 77.16859809027777 61.76648148148146 87.36067708333333 61.76648148148146C 97.55275607638889 61.76648148148146 106.28882378472221 61.76648148148146 116.48090277777777 61.76648148148146C 126.67298177083332 61.76648148148146 135.40904947916664 86.47307407407405 145.6011284722222 86.47307407407405C 155.79320746527776 86.47307407407405 164.5292751736111 86.47307407407405 174.72135416666666 86.47307407407405C 184.91343315972222 86.47307407407405 193.64950086805553 61.76648148148146 203.8415798611111 61.76648148148146C 214.03365885416665 61.76648148148146 222.76972656249998 61.76648148148146 232.96180555555554 61.76648148148146C 243.1538845486111 61.76648148148146 251.88995225694444 12.353296296296264 262.08203125 12.353296296296264C 272.27411024305553 12.353296296296264 281.01017795138887 12.353296296296264 291.2022569444444 12.353296296296264C 301.39433593749993 12.353296296296264 310.1304036458333 49.41318518518517 320.32248263888886 49.41318518518517C 330.5145616319444 49.41318518518517 339.2506293402778 49.41318518518517 349.4427083333333 49.41318518518517C 359.63478732638885 49.41318518518517 368.37085503472224 12.353296296296264 378.56293402777777 12.353296296296264C 388.7550130208333 12.353296296296264 397.49108072916664 12.353296296296264 407.6831597222222 12.353296296296264C 417.87523871527776 12.353296296296264 426.61130642361104 61.76648148148146 436.80338541666663 61.76648148148146C 446.9954644097222 61.76648148148146 455.7315321180555 61.76648148148146 465.9236111111111 61.76648148148146C 476.1156901041666 61.76648148148146 484.85175781249995 86.47307407407405 495.0438368055555 86.47307407407405C 505.2359157986111 86.47307407407405 513.9719835069444 86.47307407407405 524.1640625 86.47307407407405C 524.1640625 86.47307407407405 524.1640625 86.47307407407405 524.1640625 222.35933333333332M 524.1640625 86.47307407407405z"
                                                            pathFrom="M -1 296.4791111111111 L -1 296.4791111111111 L 29.120225694444443 296.4791111111111 L 58.240451388888886 296.4791111111111 L 87.36067708333333 296.4791111111111 L 116.48090277777777 296.4791111111111 L 145.6011284722222 296.4791111111111 L 174.72135416666666 296.4791111111111 L 203.8415798611111 296.4791111111111 L 232.96180555555554 296.4791111111111 L 262.08203125 296.4791111111111 L 291.2022569444444 296.4791111111111 L 320.32248263888886 296.4791111111111 L 349.4427083333333 296.4791111111111 L 378.56293402777777 296.4791111111111 L 407.6831597222222 296.4791111111111 L 436.80338541666663 296.4791111111111 L 465.9236111111111 296.4791111111111 L 495.0438368055555 296.4791111111111 L 524.1640625 296.4791111111111">
                                                        </path>
                                                        <path id="SvgjsPath1743"
                                                            d="M 0 74.11977777777776C 10.192078993055555 74.11977777777776 18.92814670138889 24.706592592592585 29.120225694444443 24.706592592592585C 39.312304687499996 24.706592592592585 48.04837239583333 24.706592592592585 58.240451388888886 24.706592592592585C 68.43253038194445 24.706592592592585 77.16859809027777 61.76648148148146 87.36067708333333 61.76648148148146C 97.55275607638889 61.76648148148146 106.28882378472221 61.76648148148146 116.48090277777777 61.76648148148146C 126.67298177083332 61.76648148148146 135.40904947916664 86.47307407407405 145.6011284722222 86.47307407407405C 155.79320746527776 86.47307407407405 164.5292751736111 86.47307407407405 174.72135416666666 86.47307407407405C 184.91343315972222 86.47307407407405 193.64950086805553 61.76648148148146 203.8415798611111 61.76648148148146C 214.03365885416665 61.76648148148146 222.76972656249998 61.76648148148146 232.96180555555554 61.76648148148146C 243.1538845486111 61.76648148148146 251.88995225694444 12.353296296296264 262.08203125 12.353296296296264C 272.27411024305553 12.353296296296264 281.01017795138887 12.353296296296264 291.2022569444444 12.353296296296264C 301.39433593749993 12.353296296296264 310.1304036458333 49.41318518518517 320.32248263888886 49.41318518518517C 330.5145616319444 49.41318518518517 339.2506293402778 49.41318518518517 349.4427083333333 49.41318518518517C 359.63478732638885 49.41318518518517 368.37085503472224 12.353296296296264 378.56293402777777 12.353296296296264C 388.7550130208333 12.353296296296264 397.49108072916664 12.353296296296264 407.6831597222222 12.353296296296264C 417.87523871527776 12.353296296296264 426.61130642361104 61.76648148148146 436.80338541666663 61.76648148148146C 446.9954644097222 61.76648148148146 455.7315321180555 61.76648148148146 465.9236111111111 61.76648148148146C 476.1156901041666 61.76648148148146 484.85175781249995 86.47307407407405 495.0438368055555 86.47307407407405C 505.2359157986111 86.47307407407405 513.9719835069444 86.47307407407405 524.1640625 86.47307407407405"
                                                            fill="none" fill-opacity="1" stroke="#50cd89"
                                                            stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                            stroke-dasharray="0" class="apexcharts-area" index="1"
                                                            clip-path="url(#gridRectMaskjlt6muop)"
                                                            pathTo="M 0 74.11977777777776C 10.192078993055555 74.11977777777776 18.92814670138889 24.706592592592585 29.120225694444443 24.706592592592585C 39.312304687499996 24.706592592592585 48.04837239583333 24.706592592592585 58.240451388888886 24.706592592592585C 68.43253038194445 24.706592592592585 77.16859809027777 61.76648148148146 87.36067708333333 61.76648148148146C 97.55275607638889 61.76648148148146 106.28882378472221 61.76648148148146 116.48090277777777 61.76648148148146C 126.67298177083332 61.76648148148146 135.40904947916664 86.47307407407405 145.6011284722222 86.47307407407405C 155.79320746527776 86.47307407407405 164.5292751736111 86.47307407407405 174.72135416666666 86.47307407407405C 184.91343315972222 86.47307407407405 193.64950086805553 61.76648148148146 203.8415798611111 61.76648148148146C 214.03365885416665 61.76648148148146 222.76972656249998 61.76648148148146 232.96180555555554 61.76648148148146C 243.1538845486111 61.76648148148146 251.88995225694444 12.353296296296264 262.08203125 12.353296296296264C 272.27411024305553 12.353296296296264 281.01017795138887 12.353296296296264 291.2022569444444 12.353296296296264C 301.39433593749993 12.353296296296264 310.1304036458333 49.41318518518517 320.32248263888886 49.41318518518517C 330.5145616319444 49.41318518518517 339.2506293402778 49.41318518518517 349.4427083333333 49.41318518518517C 359.63478732638885 49.41318518518517 368.37085503472224 12.353296296296264 378.56293402777777 12.353296296296264C 388.7550130208333 12.353296296296264 397.49108072916664 12.353296296296264 407.6831597222222 12.353296296296264C 417.87523871527776 12.353296296296264 426.61130642361104 61.76648148148146 436.80338541666663 61.76648148148146C 446.9954644097222 61.76648148148146 455.7315321180555 61.76648148148146 465.9236111111111 61.76648148148146C 476.1156901041666 61.76648148148146 484.85175781249995 86.47307407407405 495.0438368055555 86.47307407407405C 505.2359157986111 86.47307407407405 513.9719835069444 86.47307407407405 524.1640625 86.47307407407405"
                                                            pathFrom="M -1 296.4791111111111 L -1 296.4791111111111 L 29.120225694444443 296.4791111111111 L 58.240451388888886 296.4791111111111 L 87.36067708333333 296.4791111111111 L 116.48090277777777 296.4791111111111 L 145.6011284722222 296.4791111111111 L 174.72135416666666 296.4791111111111 L 203.8415798611111 296.4791111111111 L 232.96180555555554 296.4791111111111 L 262.08203125 296.4791111111111 L 291.2022569444444 296.4791111111111 L 320.32248263888886 296.4791111111111 L 349.4427083333333 296.4791111111111 L 378.56293402777777 296.4791111111111 L 407.6831597222222 296.4791111111111 L 436.80338541666663 296.4791111111111 L 465.9236111111111 296.4791111111111 L 495.0438368055555 296.4791111111111 L 524.1640625 296.4791111111111"
                                                            fill-rule="evenodd"></path>
                                                        <g id="SvgjsG1736"
                                                            class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                                            data:realIndex="1">
                                                            <g class="apexcharts-series-markers">
                                                                <circle id="SvgjsCircle1847" r="0" cx="0"
                                                                    cy="0"
                                                                    class="apexcharts-marker wnipdhn6t no-pointer-events"
                                                                    stroke="#50cd89" fill="#50cd89" fill-opacity="1"
                                                                    stroke-width="3" stroke-opacity="0.9"
                                                                    default-marker-size="0"></circle>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG1728" class="apexcharts-datalabels" data:realIndex="0">
                                                    </g>
                                                    <g id="SvgjsG1737" class="apexcharts-datalabels" data:realIndex="1">
                                                    </g>
                                                </g>
                                                <g id="SvgjsG1747" class="apexcharts-grid-borders">
                                                    <line id="SvgjsLine1748" x1="0" y1="0"
                                                        x2="524.1640625" y2="0" stroke="#dbdfe9"
                                                        stroke-dasharray="4" stroke-linecap="butt"
                                                        class="apexcharts-gridline"></line>
                                                </g>
                                                <line id="SvgjsLine1758" x1="0" y1="0" x2="0"
                                                    y2="222.35933333333332" stroke="#009ef7 #50cd89" stroke-dasharray="3"
                                                    stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0"
                                                    width="1" height="222.35933333333332" fill="#b1b9c4"
                                                    filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                <line id="SvgjsLine1759" x1="0" y1="0" x2="524.1640625"
                                                    y2="0" stroke="#b6b6b6" stroke-dasharray="0"
                                                    stroke-width="1" stroke-linecap="butt"
                                                    class="apexcharts-ycrosshairs"></line>
                                                <line id="SvgjsLine1760" x1="0" y1="0" x2="524.1640625"
                                                    y2="0" stroke-dasharray="0" stroke-width="0"
                                                    stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                                <g id="SvgjsG1761" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                    <g id="SvgjsG1762" class="apexcharts-xaxis-texts-g"
                                                        transform="translate(0, -10)"><text id="SvgjsText1764"
                                                            font-family="inherit" x="0" y="245.35933333333332"
                                                            text-anchor="end" dominant-baseline="auto" font-size="12px"
                                                            font-weight="400" fill="#99a1b7"
                                                            class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1765"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1767" font-family="inherit"
                                                            x="29.120225694444443" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1768"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1770" font-family="inherit"
                                                            x="58.24045138888889" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1771"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1773" font-family="inherit"
                                                            x="87.36067708333334" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;"
                                                            transform="rotate(0 88.36067962646484 240.1093292236328)">
                                                            <tspan id="SvgjsTspan1774">9 AM</tspan>
                                                            <title>9 AM</title>
                                                        </text><text id="SvgjsText1776" font-family="inherit"
                                                            x="116.48090277777777" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1777"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1779" font-family="inherit"
                                                            x="145.60112847222223" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1780"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1782" font-family="inherit"
                                                            x="174.72135416666669" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;"
                                                            transform="rotate(0 175.7213592529297 240.1093292236328)">
                                                            <tspan id="SvgjsTspan1783">12 PM</tspan>
                                                            <title>12 PM</title>
                                                        </text><text id="SvgjsText1785" font-family="inherit"
                                                            x="203.84157986111114" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1786"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1788" font-family="inherit"
                                                            x="232.9618055555556" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1789"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1791" font-family="inherit"
                                                            x="262.08203125000006" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;"
                                                            transform="rotate(0 263.08203125 240.1093292236328)">
                                                            <tspan id="SvgjsTspan1792">15 PM</tspan>
                                                            <title>15 PM</title>
                                                        </text><text id="SvgjsText1794" font-family="inherit"
                                                            x="291.2022569444445" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1795"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1797" font-family="inherit"
                                                            x="320.32248263888897" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1798"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1800" font-family="inherit"
                                                            x="349.4427083333334" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;"
                                                            transform="rotate(0 350.4427185058594 240.1093292236328)">
                                                            <tspan id="SvgjsTspan1801">18 PM</tspan>
                                                            <title>18 PM</title>
                                                        </text><text id="SvgjsText1803" font-family="inherit"
                                                            x="378.5629340277779" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1804"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1806" font-family="inherit"
                                                            x="407.68315972222234" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1807"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1809" font-family="inherit"
                                                            x="436.8033854166668" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;"
                                                            transform="rotate(0 437.8033752441406 240.1093292236328)">
                                                            <tspan id="SvgjsTspan1810">19 PM</tspan>
                                                            <title>19 PM</title>
                                                        </text><text id="SvgjsText1812" font-family="inherit"
                                                            x="465.92361111111126" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1813"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1815" font-family="inherit"
                                                            x="495.0438368055557" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1816"></tspan>
                                                            <title></title>
                                                        </text><text id="SvgjsText1818" font-family="inherit"
                                                            x="524.1640625000002" y="245.35933333333332" text-anchor="end"
                                                            dominant-baseline="auto" font-size="12px" font-weight="400"
                                                            fill="#99a1b7" class="apexcharts-text apexcharts-xaxis-label "
                                                            style="font-family: inherit;" transform="rotate(0 1 -1)">
                                                            <tspan id="SvgjsTspan1819"></tspan>
                                                            <title></title>
                                                        </text></g>
                                                </g>
                                                <g id="SvgjsG1843" class="apexcharts-yaxis-annotations"></g>
                                                <g id="SvgjsG1844" class="apexcharts-xaxis-annotations"></g>
                                                <g id="SvgjsG1845" class="apexcharts-point-annotations"></g>
                                                <rect id="SvgjsRect1848" width="0" height="0" x="0" y="0"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fefefe"
                                                    class="apexcharts-zoom-rect"></rect>
                                                <rect id="SvgjsRect1849" width="0" height="0" x="0" y="0"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fefefe"
                                                    class="apexcharts-selection-rect"></rect>
                                            </g>
                                        </svg>
                                        <div class="apexcharts-tooltip apexcharts-theme-light">
                                            <div class="apexcharts-tooltip-title"
                                                style="font-family: inherit; font-size: 12px;"></div>
                                            <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                                    class="apexcharts-tooltip-marker"
                                                    style="background-color: rgb(0, 158, 247);"></span>
                                                <div class="apexcharts-tooltip-text"
                                                    style="font-family: inherit; font-size: 12px;">
                                                    <div class="apexcharts-tooltip-y-group"><span
                                                            class="apexcharts-tooltip-text-y-label"></span><span
                                                            class="apexcharts-tooltip-text-y-value"></span></div>
                                                    <div class="apexcharts-tooltip-goals-group"><span
                                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                                            class="apexcharts-tooltip-text-goals-value"></span></div>
                                                    <div class="apexcharts-tooltip-z-group"><span
                                                            class="apexcharts-tooltip-text-z-label"></span><span
                                                            class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                            </div>
                                            <div class="apexcharts-tooltip-series-group" style="order: 2;"><span
                                                    class="apexcharts-tooltip-marker"
                                                    style="background-color: rgb(80, 205, 137);"></span>
                                                <div class="apexcharts-tooltip-text"
                                                    style="font-family: inherit; font-size: 12px;">
                                                    <div class="apexcharts-tooltip-y-group"><span
                                                            class="apexcharts-tooltip-text-y-label"></span><span
                                                            class="apexcharts-tooltip-text-y-value"></span></div>
                                                    <div class="apexcharts-tooltip-goals-group"><span
                                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                                            class="apexcharts-tooltip-text-goals-value"></span></div>
                                                    <div class="apexcharts-tooltip-z-group"><span
                                                            class="apexcharts-tooltip-text-z-label"></span><span
                                                            class="apexcharts-tooltip-text-z-value"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
                                            <div class="apexcharts-xaxistooltip-text"
                                                style="font-family: inherit; font-size: 12px;"></div>
                                        </div>
                                        <div
                                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                            <div class="apexcharts-yaxistooltip-text"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Chart widget 36-->
                    </div>
                    <!--end::Col-->
                </div>

                <!--begin::Row-->
                <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!--begin::Card widget 20-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
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
                        <!--begin::Card widget 7-->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">357</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Professionals</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                        </div>
                        <!--end::Card widget 7-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!--begin::Card widget 20-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
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
                        <!--begin::Card widget 7-->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">357</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Professionals</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                        </div>
                        <!--end::Card widget 7-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!--begin::Card widget 20-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
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
                        <!--begin::Card widget 7-->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">357</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Professionals</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                        </div>
                        <!--end::Card widget 7-->
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                        <!--begin::Card widget 20-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10"
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
                        <!--begin::Card widget 7-->
                        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">357</span>
                                    <!--end::Amount-->
                                    <!--begin::Subtitle-->
                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Professionals</span>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->

                        </div>
                        <!--end::Card widget 7-->
                    </div>
                    <!--end::Col-->


                </div>
                <!--end::Row-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection
