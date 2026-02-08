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
                            <h1 class="invoice-title">Invoice</h1>
                            <div class="billed-from">
                                <h6>BootstrapDash, Inc.</h6>
                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>{{ $order->first_name }} {{ $order->last_name }}</h6>
                                    <p>
                                        @foreach ($order->address->formatted_address as $line)
                                            {{ $line }}<br>
                                        @endforeach
                                        Email: {{ $order->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">Invoice Information</label>
                                <p class="invoice-info-row"><span>Invoice No</span> <span>{{ $order->order_number }}</span>
                                </p>
                                <p class="invoice-info-row">
                                    <span>Status</span>
                                    <span>{{ $order->status->name }}</span>
                                </p>

                                <p class="invoice-info-row">
                                    <span>Issue Date</span>
                                    <span>{{ $order->created_at->format('d M Y') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">Type</th>
                                        <th class="wd-40p">Description</th>
                                        <th class="tx-center">QNTY</th>
                                        <th class="tx-right">Unit Price</th>
                                        <th class="tx-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->stock->product->name }}</td>

                                            <td class="tx-12">
                                                @foreach ($item->attributes as $attr)
                                                    {{ $attr->name }}: {{ $attr->value }}<br>
                                                @endforeach
                                            </td>

                                            <td class="tx-center">{{ $item->qty }}</td>

                                            <td class="tx-right">
                                                {{ number_format($item->price, 2) }}
                                                @if ($item->discount > 0)
                                                    <br>
                                                    <small class="text-danger">
                                                        -{{ number_format($item->discount, 2) }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td class="tx-right">
                                                {{ number_format($item->sub_total, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">Notes</label>
                                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                                    accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab
                                                    illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                                                    explicabo.</p>
                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right">Sub-Total</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->sub_total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">VAT</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->vat, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">Shipping Cost</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->shipping_cost, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">Discount</td>
                                        <td class="tx-right" colspan="2">-{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
                                        <td class="tx-right" colspan="4">
                                            <h4 class="tx-primary tx-bold">{{ number_format($order->total, 2) }}</h4>
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
