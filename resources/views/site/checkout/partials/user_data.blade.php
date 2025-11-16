<div class="col-lg-6">
    <div class="checkout-wrapper">
        <div class="account-section billing-section" style="margin-top: 75px;">
            <h5 class="wrapper-heading">Billing Details</h5>
            <div class="review-form">
                <div class="account-inner-form">
                    <div class="review-form-name">
                        <label for="fname" class="form-label">First Name*</label>
                        <input type="text" id="fname" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ auth()->user()->name }}" />
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="review-form-name">
                        <label for="lname" class="form-label">Last Name*</label>
                        <input type="text" id="lname" name="last_name"
                            class="form-control @error('last_name') is-invalid @enderror" value="Last Name" />
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="account-inner-form">
                    <div class="review-form-name">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ auth()->user()->email }}" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="review-form-name">
                        <label for="phone" class="form-label">Phone*</label>
                        <input type="tel" id="phone" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ auth()->user()->defaultAddress->phone }}" />
                    </div>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="review-form-name">
                        <label for="additional_phone" class="form-label">Additional Phone*</label>
                        <input type="tel" id="additional_phone" name="additional_phone"
                            class="form-control @error('additional_phone') is-invalid @enderror"
                            value="{{ auth()->user()->defaultAddress->additional_phone }}" />
                    </div>
                    @error('additional_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="review-form-name address-form">
                    <label for="address" class="form-label">Address*</label>
                    <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                        placeholder="Address">{{ auth()->user()->defaultAddress->address }}</textarea>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="review-form-name">

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
                                            @if ($theCountry->id == $area->id) selected @endif>
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
                                <select class="form-control select2 @error('area_id') is-invalid @enderror"
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
                                <select class="form-control select2 @error('area_id') is-invalid @enderror"
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
                </div>


                <div class="review-form-name">
                    <label for="street" class="form-label">Street*</label>
                    <input type="text" id="street" name="street"
                        class="form-control @error('street') is-invalid @enderror"
                        value="{{ auth()->user()->defaultAddress->street }}" placeholder="Street" />
                    @error('street')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="review-form-name">
                    <label for="building" class="form-label">Building*</label>
                    <input type="text" id="building" name="building"
                        class="form-control @error('building') is-invalid @enderror"
                        value="{{ auth()->user()->defaultAddress->building }}" placeholder="Building" />
                    @error('building')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="review-form-name">
                    <label for="floor" class="form-label">Floor*</label>
                    <input type="text" id="floor" name="floor"
                        class="form-control @error('floor') is-invalid @enderror"
                        value="{{ auth()->user()->defaultAddress->floor }}" placeholder="Floor" />
                    @error('floor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="review-form-name">
                    <label for="apartment" class="form-label">Apartment*</label>
                    <input type="text" id="apartment" name="apartment"
                        class="form-control @error('apartment') is-invalid  @enderror"
                        value="{{ auth()->user()->defaultAddress->apartment }}" placeholder="Apartment" />
                    @error('apartment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="review-form-name">
                    <label for="postal_code" class="form-label">Postal Code*</label>
                    <input type="text" id="postal_code" name="postal_code"
                        class="form-control @error('postal_code') is-invalid @enderror"
                        value="{{ auth()->user()->defaultAddress->postal_code }}" placeholder="Postal Code" />
                    @error('postal_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
        </div>
    </div>
</div>
