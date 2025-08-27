<?php

namespace App\Http\Controllers;

use App\Models\AccountEntry;
use App\Models\DebitNote;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    public function index()
    {
        // Get account summary data
        $accountSummary = $this->getAccountSummary();
        $recentTransactions = $this->getRecentTransactions();
        $financialMetrics = $this->getFinancialMetrics();
        $pendingPayments = $this->getPendingPayments();
        $monthlyRevenue = $this->getMonthlyRevenue();

        return view('finance.accounts.index', compact(
            'accountSummary',
            'recentTransactions',
            'financialMetrics',
            'pendingPayments',
            'monthlyRevenue'
        ));
    }

    private function getAccountSummary()
    {
        return [
            'total_receivables' => DebitNote::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_receivables' => DebitNote::where('status', 'pending')->sum('total_amount'),
            'approved_receivables' => DebitNote::where('status', 'approved')->sum('total_amount'),
            'paid_receivables' => DebitNote::where('status', 'paid')->sum('total_amount'),
            'overdue_amount' => DebitNote::where('status', 'approved')
                ->where('due_date', '<', now())
                ->sum('total_amount'),
            'total_shipments' => Shipment::count(),
            'completed_shipments' => Shipment::where('status', 'delivered')->count(),
            'in_transit_shipments' => Shipment::where('status', 'in_transit')->count(),
        ];
    }

    private function getRecentTransactions()
    {
        return AccountEntry::with(['debitNote'])
            ->orderBy('entry_date', 'desc')
            ->limit(10)
            ->get();
    }

    private function getFinancialMetrics()
    {
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();

        return [
            'current_month_revenue' => DebitNote::where('status', 'paid')
                ->whereMonth('issue_date', $currentMonth->month)
                ->whereYear('issue_date', $currentMonth->year)
                ->sum('total_amount'),
            'last_month_revenue' => DebitNote::where('status', 'paid')
                ->whereMonth('issue_date', $lastMonth->month)
                ->whereYear('issue_date', $lastMonth->year)
                ->sum('total_amount'),
            'avg_payment_time' => DebitNote::where('status', 'paid')
                ->whereNotNull('paid_date')
                ->avg(DB::raw('DATEDIFF(paid_date, issue_date)')),
            'collection_rate' => $this->calculateCollectionRate(),
        ];
    }

    private function getPendingPayments()
    {
        return DebitNote::with(['customer', 'shipment'])
            ->where('status', 'approved')
            ->where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
    }

    private function getMonthlyRevenue()
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push([
                'month' => $date->format('M Y'),
                'revenue' => DebitNote::where('status', 'paid')
                    ->whereMonth('issue_date', $date->month)
                    ->whereYear('issue_date', $date->year)
                    ->sum('total_amount'),
                'pending' => DebitNote::where('status', 'pending')
                    ->whereMonth('issue_date', $date->month)
                    ->whereYear('issue_date', $date->year)
                    ->sum('total_amount'),
            ]);
        }

        return $months;
    }

    private function calculateCollectionRate()
    {
        $totalIssued = DebitNote::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalPaid = DebitNote::where('status', 'paid')->sum('total_amount');

        if ($totalIssued > 0) {
            return round(($totalPaid / $totalIssued) * 100, 2);
        }

        return 0;
    }
}
