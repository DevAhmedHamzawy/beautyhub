@extends('site.layouts.app')


@section('content')
    @include('site.welcome.partials.slider')

    @include('site.welcome.partials.ads_top')

    @include('site.welcome.partials.categories')

    @include('site.welcome.partials.brands')
@endsection
