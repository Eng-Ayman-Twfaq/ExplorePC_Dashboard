<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function dailySales(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        
        // جلب الطلبات مع العلاقات المطلوبة
        $orders = Order::with(['items.product', 'payment'])
            ->whereDate('orderDate', $date)
            ->get();

        // جلب المدفوعات مباشرة للتحليل
        $payments = Payment::whereDate('paymentDate', $date)
            ->where('status', 'paid')
            ->get();

        // تجميع البيانات
        $data = [
            'date' => $date,
            'total_orders' => $orders->count(),
            'total_revenue' => $payments->sum('amount'),
            'payment_methods' => $payments->groupBy('paymentMethod'),
            'top_products' => $this->getTopProducts($orders),
            'dates' => Order::selectRaw('DATE(orderDate) as date')
                ->distinct()
                ->orderBy('date', 'desc')
                ->pluck('date')
        ];

        return view('reports.daily_sales', compact('data'));
    }

   public function downloadPDF(Request $request)
{
    $date = $request->input('date', today()->format('Y-m-d'));

    // تحسين استعلامات قاعدة البيانات
    $orders = Order::with(['items.product', 'payment'])
        ->whereDate('orderDate', $date)
        ->get();

    $payments = Payment::with('order')
        ->whereDate('paymentDate', $date)
        ->where('status', 'paid')
        ->get();

    // تجميع البيانات بشكل أكثر كفاءة
    $data = [
        'date' => $date,
        'total_orders' => $orders->count(),
        'total_revenue' => $payments->sum('amount'),
        'payment_methods' => $payments->groupBy('paymentMethod'),
        'top_products' => $this->getTopProducts($orders),
        'company_info' => [
            'name' => config('app.name'),
            'logo' => public_path('images/logo.png') // تأكد من وجود الملف
        ]
    ];

     try {
        // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf.daily_sales', $data);
        
        // // الطريقة الصحيحة لتعيين الخيارات (كل خيار على حدة)
        // $dompdf = $pdf->getDomPDF();
        // $dompdf->set_option('defaultFont', 'Tajawal');
        // $dompdf->set_option('isHtml5ParserEnabled', true);
        // $dompdf->set_option('isRemoteEnabled', true);
        // $dompdf->set_option('isPhpEnabled', true);
        // $dompdf->set_option('charset', 'UTF-8');
        $pdf = PDF::loadView('reports.pdf.daily_sales', $data)
    ->setOption('fontDir', public_path('fonts'))
    ->setOption('fontCache', public_path('fonts'))
    ->setOption('defaultFont', 'Tajawal');
        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("daily_sales_report_{$date}.pdf");

    } catch (\Exception $e) {
        Log::error('PDF Generation Error: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء إنشاء التقرير: ' . $e->getMessage());
    }
}

protected function getTopProducts($orders)
{
    $productsData = [];
    
    foreach ($orders as $order) {
        foreach ($order->items as $item) {
            if (!isset($productsData[$item->productId])) {
                $productsData[$item->productId] = [
                    'product' => $item->product,
                    'quantity' => 0
                ];
            }
            $productsData[$item->productId]['quantity'] += $item->quantity;
        }
    }

    return collect($productsData)
        ->sortByDesc('quantity')
        ->take(5);
}

    public function lowStock()
    {
        $threshold = 10;
        $products = Product::with('category')
            ->where('stockQuantity', '<', $threshold)
            ->orderBy('stockQuantity')
            ->get();

        return view('reports.low_stock', [
            'products' => $products,
            'threshold' => $threshold
        ]);
    }

    public function downloadLowStockPDF()
    {
        $products = Product::with('category')
            ->where('stockQuantity', '<', 10)
            ->orderBy('stockQuantity')
            ->get();

        $pdf = Pdf::loadView('reports.pdf.low_stock', [
            'products' => $products,
            'date' => now()->format('Y-m-d')
        ])->setOption([
            'defaultFont' => 'Tajawal',
            'isHtml5ParserEnabled' => true
        ]);

        return $pdf->download("low_stock_report_" . now()->format('Y-m-d') . ".pdf");
    }
}