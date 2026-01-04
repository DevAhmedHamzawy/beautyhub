@extends('site.layouts.app')

@section('title', 'beauty hub')

@section('content')
    @include('site.welcome.partials.slider')

    @include('site.welcome.partials.ads_top')

    @include('site.welcome.partials.categories')

    @include('site.welcome.partials.brands')

    @include('site.welcome.partials.new_arrivals')

    @if ($flash_sale && $flash_sale->count() > 0)
        @include('site.welcome.partials.flash_sale')
    @endif

    @include('site.welcome.partials.top_selling')

    @include('site.welcome.partials.weekly_top_selling')

    @if ($flash_sale && $flash_sale->count() > 0)
        @include('site.welcome.partials.flash_sale_two')
    @endif

@endsection


@section('footer')

    @include('site.welcome.partials.footer')

@endsection
