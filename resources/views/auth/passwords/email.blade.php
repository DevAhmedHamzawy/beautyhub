@extends('site.layouts.app')

@section('content')
    <section class="login footer-padding">
        <div class="container">
            <div class="login-section">
                <div class="review-form">
                    <h5 class="comment-title">{{ __('auth.reset_password') }}</h5>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="review-inner-form">
                                <div class="review-form-name">
                                    <label for="email" class="form-label">{{ __('auth.email') }}*</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="{{ __('auth.email') }}" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="login-btn text-center">
                                    <button type="submit"
                                        class="shop-btn">{{ __('auth.send_password_reset_link') }}</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
