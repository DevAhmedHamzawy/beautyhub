@extends('site.layouts.app')

@section('title', 'Checkout')


@section('content')
    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="index-2.html">Home</a></span>
                <span class="devider">/</span>
                <span><a href="#">Checkout</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">Checkout</h1>
            </div>
        </div>
    </section>

    <section class="checkout product footer-padding">
        <div class="container">
            <div class="checkout-section">
                <div class="row gy-5">

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach

                    <form method="post" class="row" action="{{ route('save_order') }}">
                        @csrf

                        @include('site.checkout.partials.user_data')

                        @include('site.checkout.partials.products')
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <script>
        $(document).ready(function() {
            let item = {
                value: '{!! $theCountry->id !!}',
                dataset: {
                    level: 'governorate'
                }
            };
            getAreas(item);

            let itemone = {
                value: '{!! $theGovernorate->id !!}',
                dataset: {
                    level: 'city'
                }
            };
            getAreas(itemone);
        });


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
                            if (governorate.id == {!! $theGovernorate->id !!}) {
                                @if ($locale == 'ar')
                                    $('#governorate_id').append(
                                        `<option value="${governorate.id}" data-lat="${governorate.latitude}" data-lng="${governorate.longitude}" selected>${governorate.name}</option>`
                                    );
                                @else
                                    $('#governorate_id').append(
                                        `<option value="${governorate.id}" data-lat="${governorate.latitude}" data-lng="${governorate.longitude}" selected>${governorate.english}</option>`
                                    );
                                @endif
                            } else {
                                @if ($locale == 'ar')
                                    $('#governorate_id').append(
                                        `<option value="${governorate.id}" data-lat="${governorate.latitude}" data-lng="${governorate.longitude}">${governorate.name}</option>`
                                    );
                                @else
                                    $('#governorate_id').append(
                                        `<option value="${governorate.id}" data-lat="${governorate.latitude}" data-lng="${governorate.longitude}">${governorate.english}</option>`
                                    );
                                @endif
                            }
                        });
                    } else {
                        $('#area_id').empty();
                        $('#area_id').append(
                            `<option value="">اختر المدينة</option>`
                        )
                        response.forEach(function(city) {
                            if (city.id == {!! $theCity->id !!}) {
                                @if ($locale == 'ar')
                                    $('#area_id').append(
                                        `<option value="${city.id}" data-lat="${city.latitude}" data-lng="${city.longitude}" selected>${city.name}</option>`
                                    );
                                @else
                                    $('#area_id').append(
                                        `<option value="${city.id}" data-lat="${city.latitude}" data-lng="${city.longitude}" selected>${city.english}</option>`
                                    );
                                @endif

                            } else {
                                @if ($locale == 'ar')
                                    $('#area_id').append(
                                        `<option value="${city.id}" data-lat="${city.latitude}" data-lng="${city.longitude}">${city.name}</option>`
                                    );
                                @else
                                    $('#area_id').append(
                                        `<option value="${city.id}" data-lat="${city.latitude}" data-lng="${city.longitude}">${city.english}</option>`
                                    );
                                @endif
                            }

                        });
                    }

                }
            })
        }
    </script>
@endsection
