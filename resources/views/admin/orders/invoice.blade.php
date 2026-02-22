<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; padding: 40px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .company-name { font-size: 24px; font-weight: bold; color: #4f46e5; }
        .invoice-title { font-size: 28px; font-weight: bold; color: #6b7280; text-align: right; }
        .invoice-meta { text-align: right; color: #6b7280; margin-top: 4px; }
        .divider { border: none; border-top: 2px solid #e5e7eb; margin: 20px 0; }
        .info-grid { display: flex; gap: 40px; margin-bottom: 24px; }
        .info-block h4 { font-size: 10px; text-transform: uppercase; color: #9ca3af; letter-spacing: 0.05em; margin-bottom: 4px; }
        .info-block p { font-size: 13px; font-weight: 600; }
        .info-block small { color: #6b7280; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        thead th { background: #f9fafb; padding: 10px 12px; text-align: left; font-size: 10px; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        thead th.right { text-align: right; }
        tbody td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        tbody td.right { text-align: right; }
        tfoot td { padding: 12px; font-weight: bold; border-top: 2px solid #e5e7eb; }
        .total-row td { background: #f9fafb; }
        .total-amount { color: #4f46e5; font-size: 16px; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: #fef3c7; color: #92400e; text-transform: capitalize; }
        .footer { margin-top: 40px; padding-top: 16px; border-top: 1px solid #e5e7eb; text-align: center; color: #9ca3af; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="company-name">Ship Order</div>
            <div style="color:#6b7280; margin-top:4px;">{{ __('Ship Supply Management') }}</div>
        </div>
        <div>
            <div class="invoice-title">{{ __('INVOICE') }}</div>
            <div class="invoice-meta">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="invoice-meta">{{ $order->created_at->format('F d, Y') }}</div>
        </div>
    </div>

    <hr class="divider">

    <div class="info-grid">
        <div class="info-block">
            <h4>{{ __('Bill To') }}</h4>
            <p>{{ $order->user->company_name ?? $order->user->name }}</p>
            <small>{{ $order->user->email }}</small>
        </div>
        <div class="info-block">
            <h4>{{ __('Ship') }}</h4>
            <p>{{ $order->ship->name }}</p>
            @if($order->ship->imo_number)
                <small>IMO: {{ $order->ship->imo_number }}</small>
            @endif
        </div>
        <div class="info-block">
            <h4>{{ __('Status') }}</h4>
            <span class="status-badge">{{ $order->status }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Vendor') }}</th>
                <th class="right">{{ __('Unit Price') }}</th>
                <th class="right">{{ __('Qty') }}</th>
                <th class="right">{{ __('Subtotal') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td style="color:#6b7280">{{ $item->product->vendor->name }}</td>
                <td class="right">Rp {{ number_format($item->unit_price, 0, ",", ".") }}</td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">Rp {{ number_format($item->subtotal, 0, ",", ".") }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align:right; color:#374151;">{{ __('Total Amount') }}</td>
                <td class="right total-amount">Rp {{ number_format($order->total_price, 0, ",", ".") }}</td>
            </tr>
        </tfoot>
    </table>

    @if($order->notes)
    <div style="margin-top:24px; padding:12px; background:#f9fafb; border-radius:6px; border:1px solid #e5e7eb;">
        <strong style="font-size:10px; text-transform:uppercase; color:#6b7280;">Notes:</strong>
        <p style="margin-top:4px; color:#374151;">{{ $order->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>{{ __('Thank you for your business!') }} &bull; Ship Order Management System</p>
        <p style="margin-top:4px;">{{ __('Generated on') }} {{ now()->format('F d, Y H:i') }}</p>
    </div>
</body>
</html>
