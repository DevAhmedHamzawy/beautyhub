@extends('site.layouts.app')

@section('content')
    <section class="login footer-padding">
        <div class="container">
            <div class="login-section">
                <div class="review-form">
                    <h5 class="comment-title">{{ __('auth.reset_password') }}</h5>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="review-inner-form">
                                <div class="review-form-name">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="review-form-name">

                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="{{ trans('auth.the_password') }}" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="review-form-name">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="{{ trans('auth.password_confirmation') }}"
                                        required autocomplete="new-password">
                                </div>

                                <div class="login-btn text-center">

                                    <button type="submit" class="shop-btn">
                                        {{ __('auth.reset_password') }}
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
