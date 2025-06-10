<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    // public function index()
    // {
    //     $totalMerchants = Merchant::count(); // عدد التجار
    //     return view('dashboard', ['totalMerchants' => $totalMerchants]);
    //     // return view('dashboard', compact('totalMerchants'));
    //     // return view('dashboard');
    // }

    public function index()
    {
        $data = [
            'merchants_count' => Merchant::count(),
            'products_count' => Product::count(),
            'customers_count' => Custom::count(),
            'orders_count' => Order::count(),
            'latest_merchants' => Merchant::latest()->take(5)->get(),
            'latest_orders' => Order::with(['customer', 'merchant'])->latest()->take(5)->get(),
            
        ];
        $merchantsPerMonth = Merchant::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->whereYear('created_at', date('Y'))
    ->groupBy('month')
    ->pluck('count')
    ->toArray();

        return view('dashboard', $data);
    }


}
