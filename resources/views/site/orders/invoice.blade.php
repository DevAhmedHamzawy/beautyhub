<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <link rel="stylesheet" href="{{ asset('site/css/invoice.css') }}">
</head>

<body class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="invoice-container">

        {{-- Header --}}
        <div class="invoice-actions">
            <button onclick="window.print()" class="btn-print" title="Print Invoice">
                🖨️ Print
            </button>
        </div>
        <div class="invoice-header">
            <div class="logo">
                <h1>YOUR STORE</h1>
                <p>Official Invoice</p>
            </div>

            <div class="invoice-info">
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong> {{ $order->status->name }}</p>
            </div>
        </div>

        {{-- Billing --}}
        <div class="invoice-address">
            <div>
                <h4>Billed To</h4>
                <p>
                    {{ $order->first_name }} {{ $order->last_name }} <br>
                    {{ $order->email }}
                </p>
            </div>

            <div>
                <h4>Shipping Address</h4>
                <p>
                    @if ($order->address && $order->address->formatted_address)
                        <p>
                            @foreach ($order->address->formatted_address as $line)
                                {{ $line }} <br>
                            @endforeach
                        </p>
                    @endif
                </p>
            </div>
        </div>

        {{-- Items --}}
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Attributes</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>VAT</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->stock->product->name }}</td>

                        <td class="muted">
                            @foreach ($item->attributes as $attr)
                                {{ $attr->name }}: {{ $attr->value }}<br>
                            @endforeach
                        </td>

                        <td>{{ $item->qty }}</td>
                        <td>{{ number_format($item->price, 2) }}
                            @if ($item->discount > 0)
                                <br>
                                <small class="discount">
                                    Discount: -{{ number_format($item->discount, 2) }}
                                </small>
                            @endif
                        </td>
                        <td>{{ number_format($item->vat, 2) }}</td>
                        <td class="bold">
                            {{ number_format($item->sub_total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="invoice-summary">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>{{ number_format($order->sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td>VAT</td>
                    <td>{{ number_format($order->vat, 2) }}</td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>{{ number_format($order->shipping_cost, 2) }}</td>
                </tr>

                @if ($order->discount > 0)
                    <tr class="discount">
                        <td>Discount</td>
                        <td>-{{ number_format($order->discount, 2) }}</td>
                    </tr>
                @endif

                <tr class="total">
                    <td>Total</td>
                    <td>{{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Footer --}}
        <div class="invoice-footer">
            <p>Thank you for your purchase 💙</p>
            <small>This invoice was generated electronically.</small>
        </div>

    </div>

</body>

</html>
