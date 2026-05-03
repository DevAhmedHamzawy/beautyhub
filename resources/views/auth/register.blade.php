@extends('site.layouts.app')

@section('content')
    <section class="seller-application product footer-padding">
        <div class="container">
            <div class="seller-application-section">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="row gy-5">
                            <div class="col-lg-12">
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach
                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="seller-information" data-aos="fade-right">
                                        <h5 class="comment-title">{{ trans('auth.user_info') }}</h5>
                                        <p class="paragraph">
                                            {{ trans('auth.fill_form') }}
                                        </p>
                                        <div class="review-form">
                                            <div class="review-inner-form">


                                                <div class="review-form-name">
                                                    <label for="email"
                                                        class="form-label">{{ trans('main.name') }}*</label>
                                                    <input id="name" type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" value="{{ old('name') }}"
                                                        placeholder="{{ trans('main.name') }}" required autocomplete="name"
                                                        autofocus>

                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="review-form-name">
                                                    <label for="email"
                                                        class="form-label">{{ trans('auth.email') }}*</label>
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="{{ trans('auth.email') }}" required
                                                        autocomplete="email">

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="review-form-name">
                                                    <label for="phone"
                                                        class="form-label">{{ trans('main.password') }}*</label>
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" placeholder="{{ trans('main.password') }}" required
                                                        autocomplete="new-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="review-form-name">
                                                    <label for="phone"
                                                        class="form-label">{{ trans('auth.password_confirmation') }}*</label>
                                                    <input id="password-confirm" type="password" class="form-control"
                                                        name="password_confirmation" required autocomplete="new-password">
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="seller-information" data-aos="fade-right">
                                    <div class="review-form">
                                        <div class="review-inner-form">


                                            <div class="col-lg-12">
                                                <div class="bg-gray-200">
                                                    <div class="form-group">
                                                        <p class="mg-b-10">{{ trans('supplier.country') }}</p>
                                                        <select data-level="governorate" onchange="getAreas(this);"
                                                            class="form-control select2 @error('area_id') is-invalid @enderror">
                                                            <option value="" label="country_id">
                                                                {{ trans('supplier.country') }}
                                                            </option>
                                                            @foreach ($areas as $area)
                                                                <option value="{{ $area->id }}"
                                                                    {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                                    {{ $locale == 'ar' ? $area->name : $area->english }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('area_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="bg-gray-200">
                                                    <div class="form-group">
                                                        <p class="mg-b-10">{{ trans('supplier.governorate') }}</p>
                                                        <select
                                                            class="form-control select2 @error('area_id') is-invalid @enderror"
                                                            id="governorate_id" data-level="city" onfocus="getAreas(this)"
                                                            onchange="getAreas(this);">
                                                            <option value="" label="governorate_id">
                                                                {{ trans('supplier.city') }}
                                                            </option>
                                                        </select>
                                                        @error('area_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="bg-gray-200">
                                                    <div class="form-group">
                                                        <p class="mg-b-10">{{ trans('supplier.city') }}</p>
                                                        <select
                                                            class="form-control select2 @error('area_id') is-invalid @enderror"
                                                            name="area_id" id="area_id">
                                                            <option value="" label="area_id">
                                                                {{ trans('supplier.city') }}
                                                            </option>
                                                        </select>
                                                        @error('area_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="review-form-name">
                                                <label for="address"
                                                    class="form-label">{{ trans('main.address') }}*</label>
                                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                                                    placeholder="{{ trans('main.address') }}">{{ old('address') }}</textarea>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="street"
                                                    class="form-label">{{ trans('auth.street') }}*</label>
                                                <input type="text" id="street" name="street"
                                                    class="form-control @error('street') is-invalid @enderror"
                                                    value="{{ old('street') }}"
                                                    placeholder="{{ trans('auth.street') }}" />
                                                @error('street')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="building"
                                                    class="form-label">{{ trans('auth.building') }}*</label>
                                                <input type="text" id="building" name="building"
                                                    class="form-control @error('building') is-invalid @enderror"
                                                    value="{{ old('building') }}"
                                                    placeholder="{{ trans('auth.building') }}" />
                                                @error('building')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="floor"
                                                    class="form-label">{{ trans('auth.floor') }}*</label>
                                                <input type="text" id="floor" name="floor"
                                                    class="form-control @error('floor') is-invalid @enderror"
                                                    value="{{ old('floor') }}"
                                                    placeholder="{{ trans('auth.floor') }}" />
                                                @error('floor')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="apartment"
                                                    class="form-label">{{ trans('auth.apartment') }}*</label>
                                                <input type="text" id="apartment" name="apartment"
                                                    class="form-control @error('apartment') is-invalid  @enderror"
                                                    value="{{ old('apartment') }}"
                                                    placeholder="{{ trans('auth.apartment') }}" />
                                                @error('apartment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="postal_code"
                                                    class="form-label">{{ trans('main.zip') }}*</label>
                                                <input type="text" id="postal_code" name="postal_code"
                                                    class="form-control @error('postal_code') is-invalid @enderror"
                                                    value="{{ old('postal_code') }}"
                                                    placeholder="{{ trans('main.zip') }}" />
                                                @error('postal_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="phone"
                                                    class="form-label">{{ trans('main.phone') }}*</label>
                                                <input type="text" id="phone" name="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone') }}"
                                                    placeholder="{{ trans('main.phone') }}" />
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="review-form-name">
                                                <label for="additional_phone"
                                                    class="form-label">{{ trans('main.additional_phone') }}*</label>
                                                <input type="text" id="additional_phone" name="additional_phone"
                                                    class="form-control @error('additional_phone') is-invalid @enderror"
                                                    value="{{ old('additional_phone') }}"
                                                    placeholder="{{ trans('main.additional_phone') }}" />
                                                @error('additional_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="review-form-name checkbox">
                                                <input type="checkbox" name="agree" />
                                                <label for="address"
                                                    class="form-label @error('agree') is-invalid @enderror">
                                                    {{ trans('auth.terms') }}</label>
                                                @error('agree')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-btn">
                                                <button type="submit"
                                                    class="shop-btn">{{ trans('main.register') }}</button>
                                                <span class="shop-account">{{ trans('auth.already_have_an_account') }}?<a
                                                        href="login.html">{{ trans('auth.login') }}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="img-upload-section" data-aos="fade-left">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="logo-wrapper">
                                        <h5 class="comment-title">{{ trans('main.update_logo') }}</h5>

                                        <div class="logo-upload">
                                            <img src="assets/images/homepage-one/sallers-cover.png" alt="upload"
                                                class="upload-img" id="upload-img" />
                                            <div class="input-item upload-input">
                                                <label for="input-file">
                                                    <span>
                                                        <svg width="32" height="32" viewBox="0 0 32 32"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M16.5147 11.5C17.7284 12.7137 18.9234 13.9087 20.1296 15.115C19.9798 15.2611 19.8187 15.4109 19.6651 15.5683C17.4699 17.7635 15.271 19.9587 13.0758 22.1539C12.9334 22.2962 12.7948 22.4386 12.6524 22.5735C12.6187 22.6034 12.5663 22.6296 12.5213 22.6296C11.3788 22.6334 10.2362 22.6297 9.09365 22.6334C9.01498 22.6334 9 22.6034 9 22.536C9 21.4009 9 20.2621 9.00375 19.1271C9.00375 19.0746 9.02997 19.0109 9.06368 18.9772C10.4123 17.6249 11.7609 16.2763 13.1095 14.9277C14.2295 13.8076 15.3459 12.6913 16.466 11.5712C16.4884 11.5487 16.4997 11.5187 16.5147 11.5Z"
                                                                fill="white"></path>
                                                            <path
                                                                d="M20.9499 14.2904C19.7436 13.0842 18.5449 11.8854 17.3499 10.6904C17.5634 10.4694 17.7844 10.2446 18.0054 10.0199C18.2639 9.76139 18.5261 9.50291 18.7884 9.24443C19.118 8.91852 19.5713 8.91852 19.8972 9.24443C20.7251 10.0611 21.5492 10.8815 22.3771 11.6981C22.6993 12.0165 22.7105 12.4698 22.3996 12.792C21.9238 13.2865 21.4443 13.7772 20.9686 14.2717C20.9648 14.2792 20.9536 14.2867 20.9499 14.2904Z"
                                                                fill="white"></path>
                                                        </svg>
                                                    </span>
                                                </label>
                                                <input type="file"
                                                    accept="image/jpeg, image/jpg, image/png, image/webp"
                                                    name="main_image" id="input-file" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <script>
        function getAreas(item) {
            $.ajax({
                url: "{{ route('get_areas') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: item.value
                },
                dataType: 'json',
                success: function(response) {
                    console.log(item.dataset.level);
                    if (item.dataset.level == 'governorate') {
                        $('#governorate_id').empty();
                        $('#governorate_id').append(
                            `<option value="">اختر المدينة</option>`
                        )
                        response.forEach(function(governorate) {
                            @if ($locale == 'ar')
                                $('#governorate_id').append(
                                    `<option value="${governorate.id}" data-lat="${governorate.latitude}" data-lng="${governorate.longitude}">${governorate.name}</option>`
                                );
                            @else
                                $('#governorate_id').append(
                                    `<option value="${governorate.id}" data-lat="${governorate.latitude}" data-lng="${governorate.longitude}">${governorate.english}</option>`
                                );
                            @endif
                        });
                    } else {
                        $('#area_id').empty();
                        $('#area_id').append(
                            `<option value="">اختر المدينة</option>`
                        )
                        response.forEach(function(city) {
                            @if ($locale == 'ar')
                                $('#area_id').append(
                                    `<option value="${city.id}" data-lat="${city.latitude}" data-lng="${city.longitude}">${city.name}</option>`
                                );
                            @else
                                $('#area_id').append(
                                    `<option value="${city.id}" data-lat="${city.latitude}" data-lng="${city.longitude}">${city.english}</option>`
                                );
                            @endif

                        });
                    }

                }
            })
        }
    </script>
@endsection
