@extends('site.layouts.app')

@section('title', 'Thank You For Purchasing | Beauty Hub')

@section('content')
    <div class="min-h-screen bg-[#fff8f8] py-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                        <!-- Top Banner -->
                        <div class="bg-danger text-white text-center py-5 position-relative">
                            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <i class="fa-solid fa-bag-shopping" style="font-size: 150px"></i>
                                </div>
                            </div>

                            <div class="position-relative">
                                <div class="bg-white text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 90px; height: 90px;">
                                    <i class="fa-solid fa-check fs-1"></i>
                                </div>

                                <h1 class="fw-bold mb-2">
                                    {{ trans('order.thank_you') }}
                                </h1>

                                <p class="mb-0 fs-5 opacity-75">
                                    {{ trans('order.order_placed_successfully') }}
                                </p>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="card-body p-4 p-lg-5">

                            <div class="text-center mb-5">
                                <h3 class="fw-bold text-dark mb-3">
                                    {{ trans('order.thank_you_2') }}
                                </h3>

                                <p class="text-muted mb-0">
                                    {{ trans('order.we_preparing') }}
                                </p>
                            </div>

                            <!-- Order Info -->
                            <div class="row g-4 mb-5">

                                <div class="col-md-4">
                                    <div class="border rounded-4 p-4 text-center h-100 bg-light">
                                        <i class="fa-solid fa-hashtag text-danger fs-2 mb-3"></i>

                                        <h6 class="text-muted mb-2">
                                            {{ trans('order.order_number') }}
                                        </h6>

                                        <h5 class="fw-bold mb-0">
                                            #{{ $order->id }}
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded-4 p-4 text-center h-100 bg-light">
                                        <i class="fa-solid fa-money-bill-wave text-danger fs-2 mb-3"></i>

                                        <h6 class="text-muted mb-2">
                                            {{ trans('order.amount') }}
                                        </h6>

                                        <h5 class="fw-bold mb-0">
                                            {{ number_format($order->total, 2) }} EGP
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded-4 p-4 text-center h-100 bg-light">
                                        <i class="fa-solid fa-truck text-danger fs-2 mb-3"></i>

                                        <h6 class="text-muted mb-2">
                                            {{ trans('order.status') }}
                                        </h6>

                                        <h5 class="fw-bold mb-0 text-success">
                                            {{ trans('order.processing') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>


                            <!-- Buttons -->
                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">

                                <a href="{{ route('profile') }}" class="btn btn-danger btn-lg rounded-pill px-5">
                                    <i class="fa-solid fa-house me-2"></i>
                                    {{ trans('order.back_to_home') }}
                                </a>

                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="btn btn-outline-dark btn-lg rounded-pill px-5">
                                    <i class="fa-solid fa-receipt me-2"></i>
                                    {{ trans('order.view_order') }}
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
