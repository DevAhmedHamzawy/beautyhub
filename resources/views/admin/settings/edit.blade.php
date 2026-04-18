@extends('admin.layouts.master')

@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection

@section('title')
    {{ trans('settings.update_settings') }}
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">


            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.settings.edit') }}">{{ trans('settings.settings') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('settings.update_settings') }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ trans('settings.update_settings') }}
                    </div>
                    <form action="{{ route('admin.settings.update', $settings->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Email --}}
                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.email') }}</p>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $settings->email ?? '') }}">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.phone') }}</p>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $settings->phone ?? '') }}">
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.address') }}</p>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address', $settings->address ?? '') }}">
                                @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.location') }}</p>

                                <div id="map" style="height: 400px; border-radius: 10px;"></div>

                                <input type="hidden" name="lat" id="lat"
                                    value="{{ old('lat', $settings->lat ?? 30.0444) }}">
                                <input type="hidden" name="lng" id="lng"
                                    value="{{ old('lng', $settings->lng ?? 31.2357) }}">
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.logo') }}</p>
                                <img src="{{ $settings->logo_path }}" alt="banner" width="20%" />
                                <input type="file" name="logo_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.favicon') }}</p>
                                <img src="{{ $settings->favicon_path }}" alt="banner" width="20%" />
                                <input type="file" name="favicon_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.footer_logo') }}</p>
                                <img src="{{ $settings->footer_logo_path }}" alt="banner" width="20%" />
                                <input type="file" name="footer_logo_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.banner_one') }}</p>
                                <img src="{{ $settings->banner_one_path }}" alt="banner" width="20%" />
                                <input type="file" name="banner_one_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.banner_two') }}</p>
                                <img src="{{ $settings->banner_two_path }}" alt="banner" width="20%" />
                                <input type="file" name="banner_two_img" />
                            </div>
                        </div>


                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.banner_three') }}</p>
                                <img src="{{ $settings->banner_three_path }}" alt="banner" width="20%" />
                                <input type="file" name="banner_three_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.banner_four') }}</p>
                                <img src="{{ $settings->banner_four_path }}" alt="banner" width="20%" />
                                <input type="file" name="banner_four_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.banner_five') }}</p>
                                <img src="{{ $settings->banner_five_path }}" alt="banner" width="20%" />
                                <input type="file" name="banner_five_img" />
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="form-group">
                                <p class="mg-b-10">{{ trans('settings.banner_six') }}</p>
                                <img src="{{ $settings->banner_six_path }}" alt="banner" width="20%" />
                                <input type="file" name="banner_six_img" />
                            </div>
                        </div>

                        <div class="col-md mt-4 mt-xl-0">
                            <button class="btn btn-main-primary btn-block">{{ trans('dashboard.edit') }}</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-layouts.js') }}"></script>

    <script>
        function initMap() {
            const latInput = document.getElementById("lat");
            const lngInput = document.getElementById("lng");

            const defaultLocation = {
                lat: parseFloat(latInput.value),
                lng: parseFloat(lngInput.value)
            };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: defaultLocation,
            });

            let marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
            });

            // لما تدوس على الخريطة
            map.addListener("click", function(e) {
                marker.setPosition(e.latLng);
                updateInputs(e.latLng);
            });

            // لما تحرك الماركر
            marker.addListener("dragend", function(e) {
                updateInputs(e.latLng);
            });

            function updateInputs(location) {
                latInput.value = location.lat();
                lngInput.value = location.lng();
            }
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2obCxpDHFCwyBJe7z5EyrBTgdI1vm8RE&callback=initMap"></script>

    </script>
@endsection
