<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقرير المنتجات شبه المنتهية</title>
    <style>
        body { font-family: 'tajawal', sans-serif; direction: rtl; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: right; }
        th { background-color: #f2f2f2; }
        .critical { background-color: #ffebee; color: #d32f2f; font-weight: bold; }
    </style>
</head>
<body>
    <h1 style="text-align: center;">تقرير المنتجات شبه المنتهية</h1>
    <h3 style="text-align: center;">تاريخ التقرير: {{ now()->format('Y-m-d') }}</h3>

    <table>
        <thead>
            <tr>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>التصنيف</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr @if($product->stockQuantity < 5) class="critical" @endif>
                <td>{{ $product->name }}</td>
                <td>
                    {{ $product->stockQuantity }}
                    @if($product->stockQuantity < 5)
                    (كمية حرجة)
                    @endif
                </td>
                <td>{{ $product->category }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
