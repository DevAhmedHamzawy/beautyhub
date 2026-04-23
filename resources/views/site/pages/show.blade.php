@extends('site.layouts.app')

@section('content')
    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="{{ url('/') }}">{{ trans('main.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="#">{{ $page->title }}</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">{{ $page->title }}</h1>
            </div>
        </div>
    </section>

    <section class="product privacy footer-padding">
        <div class="container">
            <div class="privacy-section">
                <div class="policy">
                    {{ $page->content }}
                </div>
            </div>
        </div>
    </section>
@endsection
