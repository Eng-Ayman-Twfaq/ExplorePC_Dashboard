<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير المبيعات اليومية - {{ $date }}</title>
    <style>
        body {
            font-family: 'Tajawal', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            width: 30%;
            min-width: 200px;
            margin-bottom: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-print {
            display: none;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .stat-box {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 15px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            طباعة التقرير
        </button>
        <button onclick="window.close()" style="padding: 10px 15px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
            إغلاق النافذة
        </button>
    </div>

    <div class="header">
        <h1>تقرير المبيعات اليومية</h1>
        <h3>تاريخ: {{ $date }}</h3>
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

    <h2 style="text-align: right; margin-bottom: 15px;">طرق الدفع</h2>
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
                    @if($method == 'wallet') 
                        محفظة جوالي
                    @elseif($method == 'bank_transfer') 
                        تحويل بنكي
                    @elseif($method == 'cash') 
                        نقداً
                    @else 
                        {{ $method }}
                    @endif
                </td>
                <td>{{ $payments->count() }}</td>
                <td>{{ number_format($payments->sum('amount'), 2) }} $</td>
                <td>{{ $total_revenue > 0 ? round(($payments->sum('amount') / $total_revenue) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!empty($top_products))
    <h2 style="text-align: right; margin-bottom: 15px;">أفضل المنتجات مبيعاً</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم المنتج</th>
                <th>الكمية المباعة</th>
                <th>السعر</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($top_products as $productData)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $productData['product']->name }}</td>
                <td>{{ $productData['quantity'] }}</td>
                <td>{{ number_format($productData['product']->price, 2) }} $</td>
                <td>{{ number_format($productData['quantity'] * $productData['product']->price, 2) }} $</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>تم إنشاء التقرير في {{ now()->format('Y-m-d H:i') }}</p>
        <p>نظام إدارة المبيعات - جميع الحقوق محفوظة</p>
    </div>

    <script>
        // طباعة التقرير تلقائياً عند فتح الصفحة
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
        
        // إغلاق النافذة بعد الطباعة
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 500);
        };
    </script>
</body>
</html>