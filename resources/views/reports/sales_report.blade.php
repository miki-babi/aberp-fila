<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sales Report</h1>
        <p>Date: {{ now()->format('Y-m-d H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Salesperson</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Bank Transfer</th>
                <th>Cash Transfer</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->user->name ?? 'N/A' }}</td>
                <td>{{ $sale->product->name ?? 'N/A' }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ number_format($sale->bank_transfer, 2) }}</td>
                <td>{{ number_format($sale->cash_transfer, 2) }}</td>
                <td>{{ number_format($sale->total_price, 2) }}</td>
                <td>{{ $sale->sale_date }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th>{{ number_format($sales->sum('bank_transfer'), 2) }}</th>
                <th>{{ number_format($sales->sum('cash_transfer'), 2) }}</th>
                <th>{{ number_format($sales->sum('total_price'), 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
