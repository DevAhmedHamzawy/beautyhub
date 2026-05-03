<div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab" tabindex="0">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <div class="form-section">
                <form action="{{ route('change.password') }}" method="post">
                    @csrf
                    <div class="currentpass form-item">
                        <label for="currentpass" class="form-label">{{ trans('main.current_password') }}*</label>
                        <input type="password"
                            class="form-control form-control @error('current_password') is-invalid @enderror"
                            name="current_password" id="currentpass"
                            placeholder="{{ trans('main.current_password') }}" />
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="password form-item">
                        <label for="pass" class="form-label">{{ trans('main.password') }}*</label>
                        <input type="password" class="form-control form-control @error('password') is-invalid @enderror"
                            name="password" id="pass" placeholder="{{ trans('main.password') }}" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="re-password form-item">
                        <label for="repass" class="form-label">{{ trans('main.re-enter_password') }}*</label>
                        <input type="password" class="form-control" id="repass" name="password_confirmation"
                            placeholder="{{ trans('main.re-enter_password') }}" />
                    </div>
                    <div class="form-btn">
                        <button type="submit" class="shop-btn">{{ trans('main.update_password') }}</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="reset-img text-end">
                <img src="{{ asset('site/assets/images/homepage-one/reset.webp') }}" alt="reset" />
            </div>
        </div>
    </div>
</div>
