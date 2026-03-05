<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $orders = Sale::get();
        $transactions = Transaction::all();

        // Current month
        $currentMonthOrders = Sale::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Last month
        $lastMonthOrders = Sale::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // Calculate percentage
        if ($lastMonthOrders > 0) {
            $percentageIncrease = (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100;
        } else {
            $percentageIncrease = $currentMonthOrders > 0 ? 100 : 0;
        }

        $customers = Customer::get();

        // Current month
        $currentMonthCust = Customer::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Last month
        $lastMonthCust = Customer::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // Calculate percentage
        if ($lastMonthCust > 0) {
            $percentageIncreaseCust = (($currentMonthCust - $lastMonthCust) / $lastMonthCust) * 100;
        } else {
            $percentageIncreaseCust = $currentMonthCust > 0 ? 100 : 0;
        }

        // Date ranges
        $currentStart = Carbon::now()->startOfMonth();
        $currentEnd = Carbon::now()->endOfMonth();

        $lastStart = Carbon::now()->subMonth()->startOfMonth();
        $lastEnd = Carbon::now()->subMonth()->endOfMonth();

        // ===== CURRENT MONTH =====
        $currentSales = DB::table('sales')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->sum('total');

        $currentCost = DB::table('stock_purchases')
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->sum('total');

        $currentRevenue = $currentSales - $currentCost;

        // ===== LAST MONTH =====
        $lastSales = DB::table('sales')
            ->whereBetween('created_at', [$lastStart, $lastEnd])
            ->sum('total');

        $lastCost = DB::table('stock_purchases')
            ->whereBetween('created_at', [$lastStart, $lastEnd])
            ->sum('total');

        $lastRevenue = $lastSales - $lastCost;

        // ===== PERCENTAGE CALCULATION =====
        if ($lastRevenue != 0) {
            $percentageIncreaseRev = (($currentRevenue - $lastRevenue) / abs($lastRevenue)) * 100;
        } else {
            $percentageIncreaseRev = $currentRevenue > 0 ? 100 : 0;
        }

        $products = Product::get();

        $chartData = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->get();

        $labels = $chartData->pluck('name');
        $values = $chartData->pluck('total_sold');

        // Income per bulan
        $incomeByMonth = Transaction::where('type', 'income')
            ->selectRaw('DATE_FORMAT(transaction_date, "%b %Y") as month, MIN(transaction_date) as sort_date, SUM(amount) as total')
            ->groupByRaw('DATE_FORMAT(transaction_date, "%b %Y")')
            ->orderBy('sort_date')
            ->pluck('total', 'month');

        // Expense per bulan
        $expenseByMonth = Transaction::where('type', 'expense')
            ->selectRaw('DATE_FORMAT(transaction_date, "%b %Y") as month, MIN(transaction_date) as sort_date, SUM(amount) as total')
            ->groupByRaw('DATE_FORMAT(transaction_date, "%b %Y")')
            ->orderBy('sort_date')
            ->pluck('total', 'month');

        // Gabungkan semua label bulan - urutkan berdasarkan tanggal
        $allMonthsWithDate = Transaction::selectRaw('DATE_FORMAT(transaction_date, "%b %Y") as month, MIN(transaction_date) as sort_date')
            ->groupByRaw('DATE_FORMAT(transaction_date, "%b %Y")')
            ->orderBy('sort_date', 'asc')
            ->pluck('sort_date', 'month');

        $allMonths = $allMonthsWithDate->keys()->values();

        $incomeValues = $allMonths->map(fn($m) => $incomeByMonth[$m] ?? 0);
        $expenseValues = $allMonths->map(fn($m) => $expenseByMonth[$m] ?? 0);

        return view('dashboard.index', compact(
            'orders',
            'currentMonthOrders',
            'percentageIncrease',
            'customers',
            'currentMonthCust',
            'percentageIncreaseCust',
            'currentRevenue',
            'percentageIncreaseRev',
            'products',
            'labels',
            'values',
            'allMonths',
            'incomeValues',
            'expenseValues'
        ));
    }
}
