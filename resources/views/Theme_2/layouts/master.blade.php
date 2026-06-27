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
        .select2-container--open, .select2-dropdown {
            z-index: 999999 !important;
        }
        #mobileFilterModal .modal-content {
            max-height: 85vh !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: visible !important;
        }
        #mobileFilterModal .modal-body {
            max-height: 60vh !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            padding-bottom: 25px !important;
        }
        #mobileFilterModal .select2-container {
            width: 100% !important;
            display: block !important;
        }
        #mobileFilterModal .select2-selection {
            height: 45px !important;
            display: flex !important;
            align-items: center !important;
            cursor: pointer !important;
        }
        @media(max-width:1000px){
            .card-header form#filter-data,
            .card-body form#filter-data{
                display: none !important;
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
    </style>
    
    <!-- Dynamic Navbar & Sidebar Customization Styles -->
    <style>
        @php
            $sidebar_color = get_setting('sidebar_color', '#1e293b');
            $navbar_color = get_setting('navbar_color', '#ffffff');
        @endphp
        
        .bg-menu-theme {
            background-color: {{ $sidebar_color }} !important;
        }
        .bg-menu-theme .menu-inner-shadow {
            background: linear-gradient({{ $sidebar_color }} 41%, rgba(30, 41, 59, 0.11) 95%, rgba(30, 41, 59, 0)) !important;
        }
        .app-brand .layout-menu-toggle {
            border-color: {{ $sidebar_color }} !important;
        }
        
        .layout-navbar, .bg-navbar-theme {
            background-color: {{ $navbar_color }} !important;
        }

        /* Adjust Navbar text color for contrast if it is dark */
        @if(color_is_dark($navbar_color))
            .bg-navbar-theme .navbar-search-wrapper .search-input,
            .bg-navbar-theme .navbar-nav > .nav-link,
            .bg-navbar-theme .navbar-nav > .nav-item > .nav-link,
            .bg-navbar-theme .navbar-nav .show > .nav-link,
            .bg-navbar-theme .navbar-nav .active > .nav-link,
            .bg-navbar-theme .navbar-nav .nav-link i {
                color: #f8fafc !important;
            }
            .bg-navbar-theme .navbar-search-wrapper .navbar-search-icon {
                color: #cbd5e1 !important;
            }
            .bg-navbar-theme .header-org-name {
                color: #f8fafc !important;
            }
        @else
            .bg-navbar-theme .navbar-search-wrapper .search-input,
            .bg-navbar-theme .navbar-nav > .nav-link,
            .bg-navbar-theme .navbar-nav > .nav-item > .nav-link {
                color: #697a8d !important;
            }
            .bg-navbar-theme .header-org-name {
                color: #2e7d32 !important;
            }
        @endif
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
                    .footer table{
                        border:0px !important;
                    }
                    .card-body{
                        padding-top: 0.3;
                        padding-bottom: 0.3;
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
                    <body onload="window.print();window.close()">
                        <div class="card-body">
                            ${divToPrint.innerHTML}
                        </div>
                    </body>
                </html>
            `);
            newWin.document.close();
        }
    </script>
    <script>
        jQuery("form").on('submit',function(){
            if (jQuery(this).hasClass('ajax-form') || this.id === 'quickAddCustomerForm' || this.id === 'quickAddSupplierForm') {
                return;
            }
            jQuery(this).find("button[type='submit'], input[type='submit']").attr('disabled',true);
        });

        jQuery(document).ready(function($) {
            // --- MOBILE FILTERS DYNAMIC POPUP ---
            if ($(window).width() < 992) {
                var $filterForm = $('#filter-data');
                if ($filterForm.length > 0) {
                    // Create and insert mobile filter trigger button right before the filter form (above the table)
                    var $filterTrigger = $('<button type="button" class="btn btn-outline-primary w-100 mb-3 d-lg-none py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#mobileFilterModal"><i class="bx bx-filter-alt me-2 fs-5"></i>تصفية وترشيح النتائج</button>');
                    $filterForm.before($filterTrigger);
                    
                    // Append filter form to the bottom sheet modal body
                    $filterForm.appendTo('#mobileFilterModalBody');
                    
                    // Format the form elements nicely inside the bottom sheet modal
                    $filterForm.removeClass('d-flex justify-content-between').addClass('row g-3');
                    $filterForm.find('.col-12, .col-md-4, .col-md-3, .nav-item, .mb-3').each(function() {
                        $(this).removeClass('col-md-4 col-md-3 d-flex align-items-center m-2').addClass('col-12 mb-2');
                    });
                    $filterForm.find('.d-flex').each(function() {
                        if (!$(this).hasClass('filters-fields')) {
                            $(this).removeClass('d-flex').addClass('row g-2 m-0 p-0');
                        }
                    });
                    $filterForm.find('select, input').addClass('form-control-lg');

                    // Remove inline onchange and onblur so filter fields don't submit automatically on mobile
                    $filterForm.find('select, input, textarea').each(function() {
                        this.removeAttribute('onchange');
                        this.removeAttribute('onblur');
                        this.onchange = null;
                        this.onblur = null;
                    }).off('change blur');
                    
                    function initMobileSelect2() {
                        if ($.fn.select2) {
                            $('#mobileFilterModalBody').find('.form-select2, select').each(function() {
                                var $select = $(this);
                                if ($select.data('select2')) {
                                    $select.select2('destroy');
                                }
                                $select.select2({
                                    dropdownParent: $('#mobileFilterModal'),
                                    width: '100%'
                                });
                            });
                        }
                    }
                    initMobileSelect2();
                }
            }

            // Ensure Select2 dropdown opens properly when modal is shown
            $('#mobileFilterModal').on('show.bs.modal shown.bs.modal', function() {
                if ($.fn.select2) {
                    $('#mobileFilterModalBody').find('.form-select2, select').each(function() {
                        var $select = $(this);
                        if ($select.data('select2')) {
                            $select.select2('destroy');
                        }
                        $select.select2({
                            dropdownParent: $('#mobileFilterModal'),
                            width: '100%'
                        });
                    });
                }
            });

            // Explicit tap/click handler for mobile select2 container in filter modal
            $(document).on('click mousedown touchstart', '#mobileFilterModalBody .select2-container', function(e) {
                var $select = $(this).siblings('select');
                if (!$select.length) {
                    $select = $(this).prev('select');
                }
                if ($select.length && $.fn.select2) {
                    if (!$select.data('select2') || !$select.data('select2').isOpen()) {
                        $select.select2('open');
                    }
                }
            });

            // Bind Apply button in filter modal to submit the form
            $('#mobileFilterModal .btn-primary').on('click', function() {
                $('#filter-data').submit();
            });

            // --- MOBILE TABLE ACTIONS DYNAMIC POPUP ---
            var $activeTd = null;
            
            $('table tbody tr').each(function() {
                var $row = $(this);
                var $lastTd = $row.find('td:last-child');
                var $actions = $lastTd.find('> a, > button, > form, div.d-flex > a, div.d-flex > button, div.d-flex > form');
                if ($actions.length > 0) {
                    $actions.addClass('d-none d-lg-inline-flex m-1');
                    var $mobileBtn = $('<button type="button" class="btn btn-sm btn-outline-primary d-lg-none py-1 px-2 mobile-actions-trigger-btn" style="font-size:12px; font-weight:600;"><i class="bx bx-dots-vertical-rounded"></i> الإجراءات</button>');
                    $lastTd.append($mobileBtn);
                }
            });

            $(document).on('click', '.mobile-actions-trigger-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var $btn = $(this);
                var $td = $btn.parent();
                $activeTd = $td;
                
                var $row = $btn.closest('tr');
                var $table = $row.closest('table');
                
                // Find entity name dynamically
                var entityName = "";
                var nameColIndex = -1;
                $table.find('thead th').each(function(index) {
                    var text = $(this).text().trim();
                    if (text.indexOf('اسم') !== -1 || text.indexOf('الاسم') !== -1 || text.indexOf('البيان') !== -1) {
                        nameColIndex = index;
                        return false;
                    }
                });
                if (nameColIndex !== -1) {
                    entityName = $row.find('td').eq(nameColIndex).text().trim().replace(/\s+/g, ' ');
                }
                
                // Find entity code dynamically
                var entityCode = "";
                var codeColIndex = -1;
                $table.find('thead th').each(function(index) {
                    var text = $(this).text().trim();
                    if (text.indexOf('كود') !== -1 || text.indexOf('رقم') !== -1) {
                        codeColIndex = index;
                        return false;
                    }
                });
                if (codeColIndex !== -1) {
                    entityCode = $row.find('td').eq(codeColIndex).text().trim().replace(/\s+/g, ' ');
                }
                
                // Fallback for code
                if (!entityCode) {
                    entityCode = $row.find('td:first-child').text().trim().replace(/\s+/g, ' ');
                }
                
                var label = "";
                if (entityName) {
                    label = 'خيارات: ' + entityName;
                    if (entityCode) {
                        label += ' (' + entityCode + ')';
                    }
                } else {
                    label = 'خيارات سجل رقم ' + (entityCode || ($row.index() + 1));
                }
                
                $('#mobileActionsModalLabel').html('<i class="bx bx-cog me-2"></i>' + label);
                
                // Save original parent, HTML and classes before modifying
                $td.find('.d-none').each(function() {
                    var $el = $(this);
                    if (!$el.data('original-parent')) {
                        $el.data('original-parent', $el.parent());
                    }
                    if (!$el.data('original-html')) {
                        $el.data('original-html', $el.html());
                    }
                    if (!$el.data('original-class')) {
                        $el.data('original-class', $el.attr('class'));
                    }
                    if ($el.is('form')) {
                        var $inner = $el.find('a, button');
                        if ($inner.length && !$inner.data('original-html')) {
                            $inner.data('original-html', $inner.html());
                        }
                        if ($inner.length && !$inner.data('original-class')) {
                            $inner.data('original-class', $inner.attr('class'));
                        }
                    }
                });

                var $modalBody = $('#mobileActionsModalBody');
                $modalBody.empty();
                
                // Move elements to modal
                $td.find('.d-none').appendTo($modalBody).removeClass('d-none');
                
                // Style and label each action beautifully
                $modalBody.children().each(function() {
                    var $el = $(this);
                    var isForm = $el.is('form');
                    var $actionEl = isForm ? $el.find('a, button') : $el;
                    
                    var html = $actionEl.html() || '';
                    var isDelete = $actionEl.hasClass('delete-item') || html.indexOf('fa-trash') !== -1 || html.indexOf('bx-trash') !== -1;
                    var isEdit = $actionEl.hasClass('edit-customer') || $actionEl.hasClass('edit-supplier') || $actionEl.hasClass('edit-product') || $actionEl.hasClass('edit-stock') || $actionEl.hasClass('edit-expense') || $actionEl.hasClass('edit-payment') || html.indexOf('fa-edit') !== -1 || html.indexOf('bx-edit') !== -1;
                    var isView = html.indexOf('fa-eye') !== -1 || html.indexOf('bx-show') !== -1 || ($actionEl.attr('href') && $actionEl.attr('href').indexOf('show') !== -1);
                    
                    // Reset class and set layout
                    $actionEl.removeClass().addClass('btn w-100 mb-3 py-3 px-4 text-start d-flex align-items-center justify-content-between');
                    
                    if (isDelete) {
                        $actionEl.addClass('btn-label-danger');
                        $actionEl.html(`
                            <div class="d-flex align-items-center">
                                <i class="bx bx-trash me-3 fs-3 text-danger"></i>
                                <div class="text-start">
                                    <div class="fw-bold text-danger fs-5">حذف السجل</div>
                                    <small class="text-muted">حذف هذا السجل نهائياً من قاعدة البيانات</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-left text-danger"></i>
                        `);
                    } else if (isEdit) {
                        $actionEl.addClass('btn-label-primary');
                        $actionEl.html(`
                            <div class="d-flex align-items-center">
                                <i class="bx bx-edit me-3 fs-3 text-primary"></i>
                                <div class="text-start">
                                    <div class="fw-bold text-primary fs-5">تعديل البيانات</div>
                                    <small class="text-muted">تعديل وتحديث تفاصيل هذا السجل</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-left text-primary"></i>
                        `);
                    } else if (isView) {
                        $actionEl.addClass('btn-label-success');
                        $actionEl.html(`
                            <div class="d-flex align-items-center">
                                <i class="bx bx-show me-3 fs-3 text-success"></i>
                                <div class="text-start">
                                    <div class="fw-bold text-success fs-5">عرض التفاصيل</div>
                                    <small class="text-muted">عرض البيانات التفصيلية وكشف الحركات</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-left text-success"></i>
                        `);
                    } else {
                        var currentText = $actionEl.text().trim() || "إجراء إضافي";
                        $actionEl.addClass('btn-label-secondary');
                        $actionEl.html(`
                            <div class="d-flex align-items-center">
                                <i class="bx bx-cog me-3 fs-3 text-secondary"></i>
                                <div class="text-start">
                                    <div class="fw-bold text-secondary fs-5">${currentText}</div>
                                    <small class="text-muted">تنفيذ هذا الإجراء المخصص</small>
                                </div>
                            </div>
                            <i class="bx bx-chevron-left text-secondary"></i>
                        `);
                    }
                });
                
                $('#mobileActionsModal').modal('show');
            });
 
            $('#mobileActionsModal').on('hidden.bs.modal', function () {
                if ($activeTd) {
                    // Restore original HTML, classes and parent
                    $('#mobileActionsModalBody').children().each(function() {
                        var $el = $(this);
                        
                        var origHtml = $el.data('original-html');
                        var origClass = $el.data('original-class');
                        if (origHtml) $el.html(origHtml);
                        if (origClass) $el.attr('class', origClass);
                        
                        if ($el.is('form')) {
                            var $inner = $el.find('a, button');
                            var innerHtml = $inner.data('original-html');
                            var innerClass = $inner.data('original-class');
                            if (innerHtml) $inner.html(innerHtml);
                            if (innerClass) $inner.attr('class', innerClass);
                        }
                        
                        var $parent = $el.data('original-parent');
                        if ($parent && $parent.length) {
                            $el.appendTo($parent).addClass('d-none');
                        } else {
                            $el.appendTo($activeTd).addClass('d-none');
                        }
                    });
                    
                    $activeTd = null;
                }
            });
        });
   </script>
   @stack('script')

    <!-- Mobile Filter Modal -->
    <div class="modal fade bottom-sheet" id="mobileFilterModal" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title" id="mobileFilterModalLabel">تصفية وترشيح النتائج</h5>
                </div>
                <div class="modal-body" id="mobileFilterModalBody">
                    <!-- Filters move here -->
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary w-100 py-2" data-bs-dismiss="modal">تطبيق وعرض</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Actions Modal -->
    <div class="modal fade bottom-sheet" id="mobileActionsModal" tabindex="-1" aria-labelledby="mobileActionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h5 class="modal-title" id="mobileActionsModalLabel">إجراءات الصف</h5>
                </div>
                <div class="modal-body" id="mobileActionsModalBody">
                    <!-- Actions move here -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>
