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
        </div>

        {{-- Address --}}
        <div class="order-card">
            <h3>Shipping Address</h3>
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
            <h3>Order Items</h3>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Attributes</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>VAT</th>
                        <th>Total</th>
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
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->vat, 2) }}</td>
                            <td class="bold">
                                {{ number_format($item->sub_total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        <div class="order-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>{{ number_format($order->sub_total, 2) }}</span>
            </div>

            <div class="summary-row">
                <span>VAT</span>
                <span>{{ number_format($order->vat, 2) }}</span>
            </div>

            <div class="summary-row">
                <span>Shipping</span>
                <span>{{ number_format($order->shipping_cost, 2) }}</span>
            </div>

            @if ($order->discount > 0)
                <div class="summary-row discount">
                    <span>Discount</span>
                    <span>-{{ number_format($order->discount, 2) }}</span>
                </div>
            @endif

            <div class="summary-row total">
                <span>Total</span>
                <span>{{ number_format($order->total, 2) }}</span>
            </div>
        </div>

    </div>
@endsection
