<!DOCTYPE html>
<html lang="ar" class="light-style layout-menu-fixed" dir="rtl">

<head>
    <meta name="google-site-verification" content="40aCnX7tt4Ig1xeLHMATAESAkTL2pn15srB14sB-EOs" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>برنامج محاسبي شامل </title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('theme_2/assets/img/favicon/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('theme_2/assets/css/bootstrap.min.css') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/css/rtl.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('theme_2/assets/css/demo.css') }}" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/css/custome.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('theme_2/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <link href="{{ asset('theme_2/assets/css/select2.min.css') }}" rel="stylesheet">


    <!-- Helpers -->
    <script src="{{ asset('/theme_2/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('theme_2//assets/js/config.js') }}"></script>
    {{-- jquery --}}
    <script src="{{ asset('theme_2/assets/js/jquery.min.js') }}"></script>
    <link href="{{ asset('theme_2/assets/editor/summernote-lite.min.css') }}" rel="stylesheet">
    <style>
        .table th {
            padding: 15px 10px;
            color: white !important;
        }

        .table .crud {
            padding: 0px 12px;
            cursor: pointer;
        }

        .form-label {
            font-weight: bold
        }
        .modal-content{
            padding: 20px;
        }
        .select2-container--default .select2-selection--single{
            height: 36px;
            border: 1px solid #d8d3d3;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 35px;
        }
        .select2-container{
            display: block !important;
        }
        @media(max-width:1000px){
            form#filter-data{
                display: flex !important;
                flex-wrap: wrap;
            }
            form#filter-data label{
                font-size: 11px;
            }
            .table:not(.table-dark) tr th:first-child, .table:not(.table-dark) tr th:nth-child(2),
            .table:not(.table-static) tr th:first-child, .table:not(.table-static) tr th:nth-child(2),{
                background-color:#233446 !important;
            }
            .table:not(.table-dark) tr td:first-child, .table:not(.table-dark) tr td:nth-child(2),
            .table:not(.table-static) tr td:first-child, .table:not(.table-static) tr td:nth-child(2),{
                background-color:white !important;
            }
            .table .crud {
                padding: 0px 4px;
            }
            .table th , .table td {
                padding: 10px 10px;
                font-size: 12px;
            }
        }

        @media print {
            @page {
                size: 80mm auto !important; /* width: 8 cm (80mm), height: auto */
                margin: 0 !important; /* remove default margins */
            }

            body {
                width: 80mm !important;
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            .receipt {
                width: 100% !important;
                padding: 4mm !important;
            }

            /* Optional: Remove headers/footers from Chrome print */
            @page :footer { display: none !important }
            @page :header { display: none !important }
        }
    </style>
    @stack('style')
</head>

<body id="rtl">
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('Theme_2.inc.side_navbar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                @include('Theme_2.inc.top_navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    @if(flash()->message)
                    <div class="show-notify {{ flash()->class }}">
                        {{ flash()->message }}
                    </div>
                    @endif @if($errors->any())
                    <div class="show-notify alert alert-danger">
                        هناك خطأ يمكنك مراجعته
                    </div>
                    @endif

                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('Theme_2.inc.bottom_footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content-inner">
            </div>
        </div>
    </div>

    <!-- Core JS -->

    <script src="{{ asset('/theme_2/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/theme_2/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/theme_2/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('/theme_2/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('/theme_2/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/theme_2/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/theme_2/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    {{--
    <script async defer src="https://buttons.github.io/buttons.js"></script> --}} {{--
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="{{ asset('/theme_2/assets/js/select2.min.js') }}"></script>

    <script>
        jQuery('document').ready(function() {
            // paginate page 1
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        // In your Javascript (external .js resource or <script> tag)
        jQuery(document).ready(function() {
            jQuery('.form-select2').select2();
        });

        // print div
        function printDiv(element_id){
            var divToPrint=document.getElementById(element_id);
            var newWin=window.open('','Print-Window','width=400,height=600');
            const printStyles = `
                <style>
                    @media print and (max-width: 200px) {
                        .table{
                            with:100%;
                            text-align: right;
                            border:1px solid gray !important;
                        }
                        .table tr td,
                        .table th td {
                            text-align: right;
                            font-size: 11px;
                            font-weight: bold;
                        }
                        .table tr td
                        {
                            margin:0px;
                            border:1px solid gray !important;
                        }
                        .table-responsive {
                            overflow-x: visible;
                            min-height: 225px;
                        }
                        .text-nowrap {
                            white-space: nowrap !important;
                        }
                        .card {
                            box-shadow: 0px 0px;
                            border-radius: 0px;
                            background-clip: padding-box;
                            position: relative;
                            display: flex;
                            flex-direction: column;
                            min-width: 0;
                            word-wrap: break-word;
                            background-color: #fff;
                            border: 0 solid #d9dee3;
                        }
                        .card-body{
                            flex: 1 1 auto;
                            padding: 1.5rem 1.5rem;
                        }
                        .card-header {
                            padding: 1.5rem 1.5rem;
                            margin-bottom: 0;
                            background-color: transparent;
                            border-bottom: 0 solid #d9dee3;
                        }
                        .py-3 {
                            padding-top: 1rem !important;
                            padding-bottom: 1rem !important;
                        }
                        .card-header, .card-footer {
                            border-color: #d9dee3;
                        }
                        table {
                            caption-side: bottom;
                            border-collapse: collapse;
                        }
                        .table {
                            --bs-table-bg: transparent;
                            --bs-table-accent-bg: transparent;
                            --bs-table-striped-color: #697a8d;
                            --bs-table-striped-bg: #f9fafb;
                            --bs-table-active-color: #697a8d;
                            --bs-table-active-bg: rgba(67, 89, 113, 0.1);
                            --bs-table-hover-color: #697a8d;
                            --bs-table-hover-bg: rgba(67, 89, 113, 0.06);
                            width: 100%;
                            color: #697a8d;
                            vertical-align: middle;
                            border-color: #d9dee3;
                        }
                        .table>thead {
                            vertical-align: bottom;
                        }
                        .table tr {
                            border: 1px solid gray;
                        }
                        .table-light th {
                            color: #566a7f !important;
                            border-left: 1px solid lightgray;
                            padding: 6px 3px;
                            text-transform: uppercase;
                            font-size: 0.75rem;
                            letter-spacing: 1px;
                        }
                        .table> :not(caption)>*>* {
                            background-color: var(--bs-table-bg);
                            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
                        }
                    }

                    .table{
                        with:100%;
                        text-align: right;
                        border:1px solid gray !important;
                    }
                    .table tr td,
                    .table th td {
                        text-align: right;
                        font-size: 11px;
                        font-weight: bold;
                    }
                    .table tr td
                    {
                        margin:0px;
                        border:1px solid gray !important;
                    }
                    .table-responsive {
                        overflow-x: visible;
                        min-height: 225px;
                    }
                    .text-nowrap {
                        white-space: nowrap !important;
                    }
                    .card {
                        box-shadow: 0px 0px;
                        border-radius: 0px;
                        background-clip: padding-box;
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        min-width: 0;
                        word-wrap: break-word;
                        background-color: #fff;
                        border: 0 solid #d9dee3;
                    }
                    .card-body{
                        flex: 1 1 auto;
                        padding: 1.5rem 1.5rem;
                    }
                    .card-header {
                        padding: 1.5rem 1.5rem;
                        margin-bottom: 0;
                        background-color: transparent;
                        border-bottom: 0 solid #d9dee3;
                    }
                    .py-3 {
                        padding-top: 1rem !important;
                        padding-bottom: 1rem !important;
                    }
                    .card-header, .card-footer {
                        border-color: #d9dee3;
                    }
                    table {
                        caption-side: bottom;
                        border-collapse: collapse;
                    }
                    .table {
                        --bs-table-bg: transparent;
                        --bs-table-accent-bg: transparent;
                        --bs-table-striped-color: #697a8d;
                        --bs-table-striped-bg: #f9fafb;
                        --bs-table-active-color: #697a8d;
                        --bs-table-active-bg: rgba(67, 89, 113, 0.1);
                        --bs-table-hover-color: #697a8d;
                        --bs-table-hover-bg: rgba(67, 89, 113, 0.06);
                        width: 100%;
                        color: #697a8d;
                        vertical-align: middle;
                        border-color: #d9dee3;
                    }
                    .table>thead {
                        vertical-align: bottom;
                    }
                    .table tr {
                        border: 1px solid gray;
                    }
                    .table-light th {
                        color: #566a7f !important;
                        border-left: 1px solid lightgray;
                        padding: 6px 3px;
                        text-transform: uppercase;
                        font-size: 0.75rem;
                        letter-spacing: 1px;
                    }
                    .table> :not(caption)>*>* {
                        background-color: var(--bs-table-bg);
                        box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
                    }

                    @media print and (max-width: 800px) {
                        .table tr td,
                        .table th td {
                            font-size: .75em;
                            font-weight: bold;
                        }
                    }

                    @media print and (min-width:800px){
                        .table tr td,
                        .table th td {
                            font-size: 1.2em;
                            font-weight: bold;
                            padding:15px;
                            border: 3px solid gray;
                        }
                        .table-light th{
                            font-size: 1rem;
                            padding: 15px 22px;
                        }
                    }
                </style>
           `;
            newWin.document.open();
            newWin.document.write(`
                <html dir="rtl">
                    <head>
                        <title>Print</title>
                        ${printStyles}
                    </head>
                    <body onload="window.print(); window.close();">
                        <div class="card-body">
                            ${divToPrint.innerHTML}
                        </div>
                    </body>
                </html>
            `);
            newWin.document.close();
        }
    </script>
    @stack('script')

</body>

</html>
