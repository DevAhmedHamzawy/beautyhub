@extends('site.layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="order-container">

        {{-- Header --}}
        <div class="order-header">
            <div>
                <h2>Order #{{ $order->order_number }}</h2>
                <span class="order-date">
                    {{ $order->created_at->format('d M Y, h:i A') }}
                </span>
            </div>

            <span class="order-status status-{{ strtolower($order->status->name) }}">
                {{ $order->status->name }}
            </span>

            <div class="order-header-actions">
                <a href="{{ route('orders.invoice', $order->id) }}" class="btn-icon" target="_blank" title="View Invoice">
                    🧾
                </a>
            </div>
        </div>

        {{-- Address --}}
        <div class="order-card">
            <h3>{{ trans('main.shipping_address') }}</h3>
            <p>
                {{ $order->first_name }} {{ $order->last_name }} <br>
                {{ $order->address->address->street ?? '' }} <br>
                {{ $order->address->address->area->name ?? '' }},
                {{ $order->address->address->area->parent->name ?? '' }},
                {{ $order->address->address->area->parent->parent->name ?? '' }}
            </p>
        </div>

        {{-- Items --}}
        <div class="order-card">
            <h3>{{ trans('main.order_items') }}</h3>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>{{ trans('main.product') }}</th>
                        <th>{{ trans('main.attributes') }}</th>
                        <th>{{ trans('main.quantity') }}</th>
                        <th>{{ trans('main.price') }}</th>
                        <th>{{ trans('main.tax') }}</th>
                        <th>{{ trans('main.total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="product-name">
                                {{ $item->stock->product->name }}
                            </td>

                            <td class="attributes">
                                @foreach ($item->attributes as $attr)
                                    <span>{{ $attr->name }}: {{ $attr->value }}</span>
                                @endforeach
                            </td>

                            <td>{{ $item->qty }}</td>
                            <td>{{ number_format($item->price, 2) }} <span style="font-family: Arshid;">$</span>
                                @if ($item->discount > 0)
                                    <br>
                                    <small class="discount">
                                        {{ trans('main.discount') }}: -{{ number_format($item->discount, 2) }} <span
                                            style="font-family: Arshid;">$</span>
                                    </small>
                                @endif
                            </td>
                            <td>{{ number_format($item->vat, 2) }} <span style="font-family: Arshid;">$</span></td>
                            <td class="bold">
                                {{ number_format($item->sub_total, 2) }} <span style="font-family: Arshid;">$</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        <div class="order-summary">
            <div class="summary-row">
                <span>{{ trans('main.subtotal') }}</span>
                <span>{{ number_format($order->sub_total, 2) }} <span style="font-family: Arshid;">$</span></span>
            </div>

            <div class="summary-row">
                <span>{{ trans('main.tax') }}</span>
                <span>{{ number_format($order->vat, 2) }} <span style="font-family: Arshid;">$</span></span>
            </div>

            <div class="summary-row">
                <span>{{ trans('main.shipping') }}</span>
                <span>{{ number_format($order->shipping_cost, 2) }} <span style="font-family: Arshid;">$</span></span>
            </div>

            @if ($order->discount > 0)
                <div class="summary-row discount">
                    <span>{{ trans('main.discount') }}</span>
                    <span>-{{ number_format($order->discount, 2) }} <span style="font-family: Arshid;">$</span></span>
                </div>
            @endif

            <div class="summary-row total">
                <span>{{ trans('main.total') }}</span>
                <span>{{ number_format($order->total, 2) }} <span style="font-family: Arshid;">$</span></span>
            </div>
        </div>

    </div>
@endsection
