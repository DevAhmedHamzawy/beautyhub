@extends('site.layouts.app')


@section('title', 'Profile')


@section('content')



    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="index-2.html">Home</a></span>
                <span class="devider">/</span>
                <span><a href="#">Dashboard</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">User Dashboard</h1>
            </div>
        </div>
    </section>

    <section class="user-profile footer-padding">
        <div class="container">
            <div class="user-profile-section">
                <div class="dashboard-heading">
                    <h5 class="dashboard-title">Change Password</h5>
                    <div class="dashboard-switch">
                        <span class="text">Switch Dashboard</span>
                        <span onclick="switchDashboard()" class="switch-icon"></span>
                    </div>
                </div>
                <div class="user-dashboard">

                    @include('site.profile.partials.pills')

                    <div class="tab-content nav-content" id="v-pills-tabContent" style="flex: 1 0%">

                        @include('site.profile.partials.home')

                        @include('site.profile.partials.profile')

                        @include('site.profile.partials.order')

                        @include('site.profile.partials.wishlist')

                        @include('site.profile.partials.address')

                        @include('site.profile.partials.review')

                        @include('site.profile.partials.password')

                        @include('site.profile.partials.ticket')

                    </div>
                </div>
            </div>
        </div>
    </section>








@endsection
