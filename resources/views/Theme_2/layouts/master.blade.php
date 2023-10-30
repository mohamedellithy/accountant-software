<!DOCTYPE html>
<html lang="ar" class="light-style layout-menu-fixed" dir="rtl">

<head>
    <meta name="google-site-verification" content="40aCnX7tt4Ig1xeLHMATAESAkTL2pn15srB14sB-EOs" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

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
            .table:not(.table-dark) tr th:first-child, .table:not(.table-dark) tr th:nth-child(2){
                background-color:#233446 !important;
            }
            .table .crud {
                padding: 0px 4px;
            }
            .table th , .table td {
                padding: 10px 10px;
                font-size: 12px;
            }
            
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
           var newWin=window.open('','Print-Window');
           newWin.document.open();
           newWin.document.write('<html><body dir="rtl" onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
           newWin.document.close();
           setTimeout(function(){newWin.close();},10);
        }
    </script>
    @stack('script')

</body>

</html>
