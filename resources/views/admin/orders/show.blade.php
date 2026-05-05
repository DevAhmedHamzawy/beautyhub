@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
@endsection

@section('title')
    {{ trans('order.orders') }}
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">{{ trans('order.invoice') }}</h1>
                            <div class="billed-from">
                                <h6>Beauty Hub</h6>
                                <p>{{ $settings->address }}<br>
                                    Tel No: {{ $settings->phone }}<br>
                                    Email: {{ $settings->email }}</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">{{ trans('order.billed_to') }}</label>
                                <div class="billed-to">
                                    <h6>{{ $order->first_name }} {{ $order->last_name }}</h6>
                                    <p>
                                        @foreach ($order->address->formatted_address as $line)
                                            {{ $line }}<br>
                                        @endforeach
                                        {{ trans('order.email') }}: {{ $order->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">{{ trans('order.invoice_information') }}</label>
                                <p class="invoice-info-row"><span>{{ trans('order.invoice_no') }}</span>
                                    <span>{{ $order->order_number }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span>{{ trans('order.status') }}</span>
                                    <span>{{ $order->status->name }}</span>
                                </p>

                                <p class="invoice-info-row">
                                    <span>{{ trans('order.issue_date') }}</span>
                                    <span>{{ $order->created_at->format('d M Y') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">{{ trans('order.type') }}</th>
                                        <th class="wd-40p">{{ trans('order.description') }}</th>
                                        <th class="tx-center">{{ trans('order.qty') }}</th>
                                        <th class="tx-right">{{ trans('order.unit_price') }}</th>
                                        <th class="tx-right">{{ trans('order.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->stock->product->name }}</td>

                                            <td class="tx-12">
                                                @foreach ($item->attributes as $attr)
                                                    {{ $attr->translated_name }}: {{ $attr->translated_value }}<br>
                                                @endforeach
                                            </td>

                                            <td class="tx-center">{{ $item->qty }}</td>

                                            <td class="tx-right">
                                                {{ number_format($item->price, 2) }} <span
                                                    style="font-family: Arshid;">$</span>
                                                @if ($item->discount > 0)
                                                    <br>
                                                    <small class="text-danger">
                                                        -{{ number_format($item->discount, 2) }} <span
                                                            style="font-family: Arshid;">$</span>
                                                    </small>
                                                @endif
                                            </td>

                                            <td class="tx-right">
                                                {{ number_format($item->sub_total, 2) }} <span
                                                    style="font-family: Arshid;">$</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>

                                        <td class="tx-right">{{ trans('order.sub_total') }}</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->sub_total, 2) }} <span
                                                style="font-family: Arshid;">$</span></td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">{{ trans('order.vat') }}</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->vat, 2) }} <span
                                                style="font-family: Arshid;">$</span></td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">{{ trans('order.shipping_cost') }}</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->shipping_cost, 2) }}
                                            <span style="font-family: Arshid;">$</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">{{ trans('order.discount') }}</td>
                                        <td class="tx-right" colspan="2">-{{ number_format($order->discount, 2) }} <span
                                                style="font-family: Arshid;">$</span></td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">{{ trans('order.total_due') }}
                                        </td>
                                        <td class="tx-right" colspan="4">
                                            <h4 class="tx-primary tx-bold">{{ number_format($order->total, 2) }} <span
                                                    style="font-family: Arshid;">$</span></h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
@endsection
