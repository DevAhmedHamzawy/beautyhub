<!DOCTYPE html>
<html @if ($locale == 'ar') lang="ar" dir="rtl" @endif>
<!-- Mirrored from quomodothemes.website/html/shopus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 15 Nov 2023 07:46:51 GMT -->

<head>
    <meta charset="utf-8" />
    <meta name="keywords"
        content="ShopUS, bootstrap-5, bootstrap, sass, css, HTML Template, HTML,html, bootstrap template, free template, figma, web design, web development,front end, bootstrap datepicker, bootstrap timepicker, javascript, ecommerce template" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ $settings->favicon_path }}" />

    <title>@yield('title')</title>

    @if ($locale == 'ar')
        <link rel="stylesheet" href="{{ asset('site/css/bootstrap.rtl.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('site/css/style_ar.css') }}" />
    @else
        <link rel="stylesheet" href="{{ asset('site/css/bootstrap-5.3.2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('site/css/style.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('site/css/swiper10-bundle.min.css') }}" />


    <link rel="stylesheet" href="{{ asset('site/css/nouislider.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('site/css/aos-3.0.0.css') }}" />


    <link href="{{ URL::asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('header')
</head>

<body>

    @include('site.layouts.header')

    @yield('content')

    @include('site.layouts.footer')
