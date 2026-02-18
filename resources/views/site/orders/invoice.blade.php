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
                <p><strong>{{ trans('order.invoice') }} #:</strong> {{ $order->order_number }}</p>
                <p><strong>{{ trans('order.issue_date') }}:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>{{ trans('order.status') }}:</strong> {{ $order->status->name }}</p>
            </div>
        </div>

        {{-- Billing --}}
        <div class="invoice-address">
            <div>
                <h4>{{ trans('order.billed_to') }}</h4>
                <p>
                    {{ $order->first_name }} {{ $order->last_name }} <br>
                    {{ $order->email }}
                </p>
            </div>

            <div>
                <h4>{{ trans('order.shipping_address') }}</h4>
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
                    <th>{{ trans('order.type') }}</th>
                    <th>{{ trans('order.description') }}</th>
                    <th>{{ trans('order.qty') }}</th>
                    <th>{{ trans('order.unit_price') }}</th>
                    <th>{{ trans('order.vat') }}</th>
                    <th>{{ trans('order.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->stock->product->name }}</td>

                        <td class="muted">
                            @foreach ($item->attributes as $attr)
                                {{ $attr->translated_name }}: {{ $attr->translated_value }}<br>
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
                    <td>{{ trans('order.subtotal') }}</td>
                    <td>{{ number_format($order->sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td>{{ trans('order.vat') }}</td>
                    <td>{{ number_format($order->vat, 2) }}</td>
                </tr>
                <tr>
                    <td>{{ trans('order.shipping_cost') }}</td>
                    <td>{{ number_format($order->shipping_cost, 2) }}</td>
                </tr>

                @if ($order->discount > 0)
                    <tr class="discount">
                        <td>{{ trans('order.discount') }}</td>
                        <td>-{{ number_format($order->discount, 2) }}</td>
                    </tr>
                @endif

                <tr class="total">
                    <td>{{ trans('order.total') }}</td>
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
