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
        // KPIs (demo data)
        $kpis = [
            'total_indents' => 18,
            'total_lcs' => 14,
            'total_shipments' => 20,
            'total_customers' => 25,
            'total_products' => 50,
            'total_principals' => 20,
        ];

        // Alerts (demo data)
        $alerts = [
            'pending_quotations' => 5,
            'expiring_lcs' => 3,
            'pending_shipments' => 8,
        ];

        // Chart data (pharmaceutical demo data)
        $chartData = [
            'indent_volume' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [1250, 1890, 1560, 2480, 2230, 3050],
            ],
            'shipment_volume' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [1180, 1750, 1420, 2280, 2080, 2850],
                'target' => [1500, 1500, 1500, 1500, 1500, 1500],
            ],
            'customer_business' => [
                'labels' => ['DMCH', 'Square Hospital', 'Apollo Hospitals', 'United Hospital', 'Popular Medical'],
                'data' => [1250000, 980000, 1560000, 870000, 1340000],
            ],
        ];

        return view('dashboard', compact('kpis', 'alerts', 'chartData'));
    }
}
