<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="{{ asset('favicon.ico') }}" rel="icon">
    <title>Gusto System</title>
   @if (App::getLocale() === 'en')
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
@else
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.rtl.css') }}" rel="stylesheet" type="text/css">
@endif
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">


<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<link href="{{ asset('css/table.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

<style>


    @import url(https://fonts.googleapis.com/css?family=Droid+Sans);

    .loadPage {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif?e44397') 50% 50% no-repeat rgb(249, 249, 249);
    }


    .box {
        width: 45%;
        background: rgba(226, 226, 226, 1);
        background: -moz-linear-gradient(left, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 10%, rgba(209, 209, 209, 1) 98%, rgba(254, 254, 254, 1) 100%);
        background: -webkit-gradient(left top, right top, color-stop(0%, rgba(226, 226, 226, 1)), color-stop(10%, rgba(219, 219, 219, 1)), color-stop(98%, rgba(209, 209, 209, 1)), color-stop(100%, rgba(254, 254, 254, 1)));
        background: -webkit-linear-gradient(left, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 10%, rgba(209, 209, 209, 1) 98%, rgba(254, 254, 254, 1) 100%);
        background: -o-linear-gradient(left, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 10%, rgba(209, 209, 209, 1) 98%, rgba(254, 254, 254, 1) 100%);
        background: -ms-linear-gradient(left, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 10%, rgba(209, 209, 209, 1) 98%, rgba(254, 254, 254, 1) 100%);
        background: linear-gradient(to right, rgba(226, 226, 226, 1) 0%, rgba(219, 219, 219, 1) 10%, rgba(209, 209, 209, 1) 98%, rgba(254, 254, 254, 1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e2e2e2', endColorstr='#fefefe', GradientType=1);

    }

    .outer-box {
        margin-top: 60px;
        margin-left: 450px;
    }
</style>
<style>
    /* .dataTables_wrapper.dt-bootstrap4.no-footer {
        width: 100vw !important;
        overflow: scroll;
    }

    .dataTables_paginate.paging_simple_numbers {
        width: 100%;
    }

    .dataTables_info {
        /* display: none; */
    }

    /*
    ul.pagination {
        justify-content: center !important
    }

    #DataTables_Table_0_wrapper>.row:first-child,
    #DataTables_Table_0_wrapper>.row:last-child {
        display: none;
    }

    .row>*,
    input,
    select {
        text-align: center
    } */
    */
</style>
@if (App::getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
@endif

</head>
