@extends('site.layouts.app')

@section('content')
    <section class="login footer-padding">
        <div class="container">
            <div class="login-section">
                <div class="review-form">
                    <h5 class="comment-title">{{ __('auth.verify_your_email_address') }}</h5>


                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <h4>{{ __('auth.a_fresh_verification_link_has_been_sent_to_your_email_address') }}</h4>
                        </div>
                    @endif

                    <h3>
                        {{ __('auth.before_proceeding') }}
                        {{ __('auth.if_you_didnt_receive_the_email') }},
                    </h3>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline"
                            style="font-size: 18px;">{{ __('auth.click_here_to_request_another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
