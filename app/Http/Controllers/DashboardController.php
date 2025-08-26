<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Indent;
use App\Models\LetterOfCredit;
use App\Models\Product;
use App\Models\Principal;
use App\Models\Quotation;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $kpis = [
            'total_indents' => Indent::count(),
            'total_lcs' => LetterOfCredit::count(),
            'total_shipments' => Shipment::count(),
            'total_customers' => Customer::count(),
            'total_products' => Product::count(),
            'total_principals' => Principal::count(),
        ];

        // Alerts
        $alerts = [
            'pending_quotations' => Quotation::where('status', 'Draft')->count(),
            'expiring_lcs' => LetterOfCredit::where('expiry_date', '<=', Carbon::now()->addDays(30))->count(),
            'pending_shipments' => Shipment::where('status', 'Pending')->count(),
        ];

        // Chart data (static for demo)
        $chartData = [
            'indent_volume' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [12, 19, 15, 25, 22, 30],
            ],
            'shipment_volume' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [10, 15, 12, 20, 18, 25],
                'target' => [15, 15, 15, 15, 15, 15],
            ],
            'customer_business' => [
                'labels' => ['ABC Trading', 'XYZ Importers', 'Global Merchants', 'Pacific Traders', 'Euro Commerce'],
                'data' => [45000, 38000, 32000, 28000, 25000],
            ],
        ];

        return view('dashboard', compact('kpis', 'alerts', 'chartData'));
    }
}
