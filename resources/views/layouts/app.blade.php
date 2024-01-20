<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{config('app.name')}}</title>

    <!-- Global stylesheets -->
    <link href="{{asset('css/inter.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    @stack('stylesheet')
</head>

<body>
<div class="loader" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: none; z-index: 9999;">
    <i class="ph-spinner spinner" style="color: #fff;font-size: 80px;position: absolute;top: 50%;left: 50%;transform: translate(-44px);">
    </i>
</div>
<!-- Main navbar -->
@include('partials.navbar')
<!-- /main navbar -->
<div class="page-content">
    @include('partials.sidebar')
    <div class="content-wrapper">
        <div class="content-inner">
            @yield('content')
            @include('partials.footer')
        </div>
    </div>
</div>
@stack('footer-modal')
<!-- Core JS files -->
<script src="{{asset('js/demo_configurator.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- /core JS files -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/dashboard.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/form_layouts.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/table_elements.js')}}"></script>
<script src="{{asset('js/form_select2.js')}}"></script>
@stack('scripts')
</body>
</html>
