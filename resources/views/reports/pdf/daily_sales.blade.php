<!DOCTYPE html>
<html dir="rtl">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <title>تقرير المبيعات اليومية - {{ $date }}</title>
    <style>
        /* إضافة خط يدعم العربية */
        @font-face {
        font-family: 'Tajawal';
        src: url("{{ public_path('fonts/Tajawal/Tajawal-Regular.ttf') }}") format('truetype');
    }
    body {
        font-family: 'Tajawal', sans-serif;
        direction: rtl;
        text-align: right;
    }
        
        /* body {
            font-family: 'Tajawal', sans-serif;
            
        } */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="text-align: center;">تقرير المبيعات اليومية</h1>
    <h3 style="text-align: center;">تاريخ: {{ $date }}</h3>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <h3>عدد الطلبات</h3>
            <p style="font-size: 24px; font-weight: bold;">{{ $total_orders }}</p>
        </div>
        <div class="stat-box">
            <h3>إجمالي الإيراد</h3>
            <p style="font-size: 24px; font-weight: bold;">{{ number_format($total_revenue, 2) }} $</p>
        </div>
        <div class="stat-box">
            <h3>متوسط قيمة الطلب</h3>
            <p style="font-size: 24px; font-weight: bold;">
                {{ $total_orders > 0 ? number_format($total_revenue / $total_orders, 2) : 0 }} $
            </p>
        </div>
    </div>

    <h2 style="text-align: right; margin-bottom: 10px;">طرق الدفع</h2>
    <table>
        <thead>
            <tr>
                <th>طريقة الدفع</th>
                <th>عدد الطلبات</th>
                <th>المبلغ</th>
                <th>النسبة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment_methods as $method => $payments)
            <tr>
                <td>
                    @if($method == 'wallet') محفظة جوالي
                    @elseif($method == 'bank_transfer') تحويل بنكي
                    @elseif($method == 'cash') نقداً
                    @else {{ $method }}
                    @endif
                </td>
                <td>{{ $payments->count() }}</td>
                <td>{{ number_format($payments->sum('amount'), 2) }} $</td>
              <td>{{ $total_revenue > 0 ? round($payments->sum('amount') / $total_revenue * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!empty($top_products))
    <h2 style="text-align: right; margin-bottom: 10px;">أفضل المنتجات مبيعاً</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم المنتج</th>
                <th>الكمية المباعة</th>
                <th>السعر</th>
            </tr>
        </thead>
        <tbody>
            @foreach($top_products as $productData)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $productData['product']->name }}</td>
                <td>{{ $productData['quantity'] }}</td>
                <td>{{ number_format($productData['product']->price, 2) }} $</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>تم إنشاء التقرير في {{ now()->format('Y-m-d H:i') }}</p>
    </div>
</body>
</html>