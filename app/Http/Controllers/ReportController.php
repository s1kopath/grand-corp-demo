<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DebitNote;
use App\Models\Indent;
use App\Models\LetterOfCredit;
use App\Models\Principal;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $reports = $this->getReportsList();
        $reportStats = $this->getReportStats();

        return view('reports.index', compact('reports', 'reportStats'));
    }

    public function export($slug)
    {
        $report = $this->getReportBySlug($slug);

        if (!$report) {
            abort(404, 'Report not found');
        }

        // Generate sample data for the report
        $data = $this->generateReportData($slug);

        // Return a sample file download
        $filename = $report['filename'];
        $content = $this->generateSampleContent($slug, $data);

        return response($content)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Detailed Report Methods
    public function paretoAnalysis()
    {
        $data = $this->generateParetoAnalysisData();
        return view('reports.pareto-analysis', compact('data'));
    }

    public function principalProductVolume()
    {
        $data = $this->generatePrincipalProductVolumeData();
        return view('reports.principal-product-volume', compact('data'));
    }

    public function productPrincipalEngagement()
    {
        $data = $this->generateProductPrincipalEngagementData();
        return view('reports.product-principal-engagement', compact('data'));
    }

    public function indentsVsShipments()
    {
        $data = $this->generateIndentsVsShipmentsData();
        return view('reports.indents-vs-shipments', compact('data'));
    }

    public function customerBusinessVolume()
    {
        $data = $this->generateCustomerBusinessVolumeData();
        return view('reports.customer-business-volume', compact('data'));
    }

    public function outstandingPayments()
    {
        $data = $this->generateOutstandingPaymentsData();
        return view('reports.outstanding-payments', compact('data'));
    }

    public function lcExpiryAnalysis()
    {
        $data = $this->generateLcExpiryAnalysisData();
        return view('reports.lc-expiry-analysis', compact('data'));
    }

    private function getReportsList()
    {
        return [
            [
                'slug' => 'sales-performance',
                'title' => 'Sales Performance Report',
                'description' => 'Monthly sales performance by customer, product, and region',
                'icon' => 'trending_up',
                'color' => 'success',
                'filename' => 'sales_performance_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(2)->format('M d, Y H:i'),
                'records' => 1250
            ],
            [
                'slug' => 'customer-analysis',
                'title' => 'Customer Analysis Report',
                'description' => 'Customer profitability, order history, and business volume',
                'icon' => 'people',
                'color' => 'primary',
                'filename' => 'customer_analysis_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(1)->format('M d, Y H:i'),
                'records' => 89
            ],
            [
                'slug' => 'inventory-status',
                'title' => 'Inventory Status Report',
                'description' => 'Current inventory levels, stock movements, and reorder points',
                'icon' => 'inventory',
                'color' => 'warning',
                'filename' => 'inventory_status_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subHours(6)->format('M d, Y H:i'),
                'records' => 340
            ],
            [
                'slug' => 'financial-summary',
                'title' => 'Financial Summary Report',
                'description' => 'Revenue, receivables, payment status, and financial metrics',
                'icon' => 'account_balance',
                'color' => 'info',
                'filename' => 'financial_summary_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subHours(12)->format('M d, Y H:i'),
                'records' => 567
            ],
            [
                'slug' => 'logistics-performance',
                'title' => 'Logistics Performance Report',
                'description' => 'Shipment tracking, delivery times, and logistics costs',
                'icon' => 'local_shipping',
                'color' => 'secondary',
                'filename' => 'logistics_performance_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(3)->format('M d, Y H:i'),
                'records' => 234
            ],
            [
                'slug' => 'supplier-analysis',
                'title' => 'Supplier Analysis Report',
                'description' => 'Principal performance, product portfolio, and supplier metrics',
                'icon' => 'business',
                'color' => 'dark',
                'filename' => 'supplier_analysis_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(4)->format('M d, Y H:i'),
                'records' => 156
            ],
            [
                'slug' => 'compliance-report',
                'title' => 'Compliance Report',
                'description' => 'Regulatory compliance, certificates, and audit trails',
                'icon' => 'verified',
                'color' => 'success',
                'filename' => 'compliance_report_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(5)->format('M d, Y H:i'),
                'records' => 89
            ],
            [
                'slug' => 'operational-metrics',
                'title' => 'Operational Metrics Report',
                'description' => 'Key performance indicators and operational efficiency metrics',
                'icon' => 'analytics',
                'color' => 'primary',
                'filename' => 'operational_metrics_' . date('Y-m-d') . '.xlsx',
                'last_generated' => now()->subDays(1)->format('M d, Y H:i'),
                'records' => 445
            ]
        ];
    }

    private function getReportStats()
    {
        return [
            'total_reports' => 8,
            'reports_generated_today' => 3,
            'total_records_exported' => 3180,
            'most_popular_report' => 'Sales Performance Report',
            'average_generation_time' => '2.3 minutes'
        ];
    }

    private function getReportBySlug($slug)
    {
        $reports = $this->getReportsList();

        foreach ($reports as $report) {
            if ($report['slug'] === $slug) {
                return $report;
            }
        }

        return null;
    }

    private function generateReportData($slug)
    {
        switch ($slug) {
            case 'sales-performance':
                return [
                    'total_sales' => Quotation::where('status', 'approved')->count(),
                    'total_revenue' => DebitNote::where('status', 'paid')->sum('total_amount'),
                    'top_customers' => Customer::withCount('quotations')->orderBy('quotations_count', 'desc')->limit(5)->get(),
                    'top_products' => Product::withCount('quotationItems')->orderBy('quotation_items_count', 'desc')->limit(5)->get()
                ];

            case 'customer-analysis':
                return [
                    'total_customers' => Customer::count(),
                    'active_customers' => Customer::whereHas('quotations')->count(),
                    'customer_regions' => Customer::select('region', DB::raw('count(*) as count'))->groupBy('region')->get(),
                    'customer_business_volume' => Customer::withSum('debitNotes', 'total_amount')->orderBy('debit_notes_sum_total_amount', 'desc')->limit(10)->get()
                ];

            case 'inventory-status':
                return [
                    'total_products' => Product::count(),
                    'active_products' => Product::where('status', 'active')->count(),
                    'product_categories' => Product::select('category', DB::raw('count(*) as count'))->groupBy('category')->get(),
                    'low_stock_products' => Product::where('stock_quantity', '<', 10)->get()
                ];

            case 'financial-summary':
                return [
                    'total_receivables' => DebitNote::where('status', '!=', 'cancelled')->sum('total_amount'),
                    'paid_receivables' => DebitNote::where('status', 'paid')->sum('total_amount'),
                    'pending_receivables' => DebitNote::where('status', 'pending')->sum('total_amount'),
                    'overdue_amount' => DebitNote::where('status', 'approved')->where('due_date', '<', now())->sum('total_amount')
                ];

            case 'logistics-performance':
                return [
                    'total_shipments' => Shipment::count(),
                    'completed_shipments' => Shipment::where('status', 'delivered')->count(),
                    'in_transit_shipments' => Shipment::where('status', 'in_transit')->count(),
                    'average_delivery_time' => 15.5 // days
                ];

            case 'supplier-analysis':
                return [
                    'total_principals' => Principal::count(),
                    'active_principals' => Principal::where('status', 'active')->count(),
                    'principal_countries' => Principal::select('country', DB::raw('count(*) as count'))->groupBy('country')->get(),
                    'top_principals' => Principal::withCount('products')->orderBy('products_count', 'desc')->limit(5)->get()
                ];

            case 'compliance-report':
                return [
                    'total_certificates' => DB::table('certificates')->count(),
                    'valid_certificates' => DB::table('certificates')->where('status', 'valid')->count(),
                    'expired_certificates' => DB::table('certificates')->where('status', 'expired')->count(),
                    'compliance_score' => 94.5
                ];

            case 'operational-metrics':
                return [
                    'total_quotations' => Quotation::count(),
                    'total_indents' => Indent::count(),
                    'total_lcs' => LetterOfCredit::count(),
                    'conversion_rate' => 78.5 // percentage
                ];

            default:
                return [];
        }
    }

    private function generateSampleContent($slug, $data)
    {
        // Generate a simple CSV-like content for demo purposes
        $content = "Report: " . ucwords(str_replace('-', ' ', $slug)) . "\n";
        $content .= "Generated: " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "Records: " . ($data['total_sales'] ?? $data['total_customers'] ?? $data['total_products'] ?? 0) . "\n\n";

        // Add some sample data rows
        $content .= "Sample Data:\n";
        $content .= "ID,Name,Value,Status\n";
        $content .= "1,Sample Record 1,1000.00,Active\n";
        $content .= "2,Sample Record 2,2500.00,Active\n";
        $content .= "3,Sample Record 3,1800.00,Pending\n";
        $content .= "4,Sample Record 4,3200.00,Completed\n";
        $content .= "5,Sample Record 5,950.00,Active\n";

        return $content;
    }

    // Data Generation Methods for Detailed Reports
    private function generateParetoAnalysisData()
    {
        // 80/20 Analysis - Top customers by revenue
        $customers = Customer::withSum('debitNotes', 'total_amount')
            ->orderBy('debit_notes_sum_total_amount', 'desc')
            ->limit(10)
            ->get();

        $totalRevenue = $customers->sum('debit_notes_sum_total_amount');
        $cumulativePercentage = 0;

        $paretoData = $customers->map(function ($customer, $index) use ($totalRevenue, &$cumulativePercentage) {
            $percentage = $totalRevenue > 0 ? ($customer->debit_notes_sum_total_amount / $totalRevenue) * 100 : 0;
            $cumulativePercentage += $percentage;

            return [
                'rank' => $index + 1,
                'name' => $customer->name,
                'total_value' => $customer->debit_notes_sum_total_amount ?? 0,
                'percentage' => round($percentage, 2),
                'cumulative_percentage' => round($cumulativePercentage, 2)
            ];
        });

        return [
            'pareto_data' => $paretoData,
            'total_revenue' => $totalRevenue,
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT'
        ];
    }

    private function generatePrincipalProductVolumeData()
    {
        // Principal-wise product volume analysis - Demo Data
        $principals = [
            [
                'principal_name' => 'Pfizer Inc',
                'product_count' => 15,
                'total_indent_volume' => 25000,
                'total_shipment_volume' => 22000,
                'shipped_on_time_percentage' => 94.5
            ],
            [
                'principal_name' => 'Novartis AG',
                'product_count' => 12,
                'total_indent_volume' => 22000,
                'total_shipment_volume' => 19500,
                'shipped_on_time_percentage' => 91.2
            ],
            [
                'principal_name' => 'Johnson & Johnson',
                'product_count' => 18,
                'total_indent_volume' => 28000,
                'total_shipment_volume' => 26500,
                'shipped_on_time_percentage' => 96.8
            ],
            [
                'principal_name' => 'Roche Holding AG',
                'product_count' => 10,
                'total_indent_volume' => 18000,
                'total_shipment_volume' => 16500,
                'shipped_on_time_percentage' => 89.3
            ],
            [
                'principal_name' => 'Merck & Co',
                'product_count' => 14,
                'total_indent_volume' => 21000,
                'total_shipment_volume' => 19000,
                'shipped_on_time_percentage' => 92.7
            ],
            [
                'principal_name' => 'Sun Pharmaceutical',
                'product_count' => 20,
                'total_indent_volume' => 32000,
                'total_shipment_volume' => 29500,
                'shipped_on_time_percentage' => 88.9
            ],
            [
                'principal_name' => 'Dr. Reddy\'s Laboratories',
                'product_count' => 16,
                'total_indent_volume' => 24000,
                'total_shipment_volume' => 21500,
                'shipped_on_time_percentage' => 93.1
            ],
            [
                'principal_name' => 'Cipla Ltd',
                'product_count' => 13,
                'total_indent_volume' => 19000,
                'total_shipment_volume' => 17500,
                'shipped_on_time_percentage' => 90.5
            ]
        ];

        return [
            'principals' => collect($principals)->sortByDesc('total_indent_volume'),
            'report_date' => now()->format('M d, Y'),
            'total_principals' => count($principals)
        ];
    }

    private function generateProductPrincipalEngagementData()
    {
        // Product-wise principal engagement - Demo Data
        $products = [
            [
                'product_name' => 'Amoxicillin 500mg',
                'principal' => 'Pfizer Inc',
                'total_orders' => 45,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 3
            ],
            [
                'product_name' => 'Paracetamol 500mg',
                'principal' => 'Novartis AG',
                'total_orders' => 38,
                'avg_shipment_delay' => 1,
                'outstanding_indent' => 1
            ],
            [
                'product_name' => 'Metformin 500mg',
                'principal' => 'Johnson & Johnson',
                'total_orders' => 42,
                'avg_shipment_delay' => 3,
                'outstanding_indent' => 5
            ],
            [
                'product_name' => 'Amlodipine 5mg',
                'principal' => 'Roche Holding AG',
                'total_orders' => 35,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 2
            ],
            [
                'product_name' => 'Insulin Regular',
                'principal' => 'Merck & Co',
                'total_orders' => 28,
                'avg_shipment_delay' => 4,
                'outstanding_indent' => 7
            ],
            [
                'product_name' => 'COVID-19 Vaccine',
                'principal' => 'Sun Pharmaceutical',
                'total_orders' => 52,
                'avg_shipment_delay' => 1,
                'outstanding_indent' => 0
            ],
            [
                'product_name' => 'Stethoscope',
                'principal' => 'Dr. Reddy\'s Laboratories',
                'total_orders' => 31,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 4
            ],
            [
                'product_name' => 'Blood Pressure Monitor',
                'principal' => 'Cipla Ltd',
                'total_orders' => 25,
                'avg_shipment_delay' => 3,
                'outstanding_indent' => 6
            ],
            [
                'product_name' => 'Surgical Mask',
                'principal' => 'Pfizer Inc',
                'total_orders' => 48,
                'avg_shipment_delay' => 1,
                'outstanding_indent' => 2
            ],
            [
                'product_name' => 'COVID-19 Test Kit',
                'principal' => 'Novartis AG',
                'total_orders' => 55,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 1
            ],
            [
                'product_name' => 'Ciprofloxacin 250mg',
                'principal' => 'Johnson & Johnson',
                'total_orders' => 33,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 3
            ],
            [
                'product_name' => 'Ibuprofen 400mg',
                'principal' => 'Roche Holding AG',
                'total_orders' => 29,
                'avg_shipment_delay' => 1,
                'outstanding_indent' => 1
            ],
            [
                'product_name' => 'Thermometer Digital',
                'principal' => 'Merck & Co',
                'total_orders' => 22,
                'avg_shipment_delay' => 3,
                'outstanding_indent' => 5
            ],
            [
                'product_name' => 'Surgical Gloves',
                'principal' => 'Sun Pharmaceutical',
                'total_orders' => 41,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 4
            ],
            [
                'product_name' => 'Pregnancy Test Kit',
                'principal' => 'Dr. Reddy\'s Laboratories',
                'total_orders' => 27,
                'avg_shipment_delay' => 2,
                'outstanding_indent' => 3
            ]
        ];

        return [
            'products' => collect($products)->sortByDesc('total_orders'),
            'report_date' => now()->format('M d, Y'),
            'total_products' => count($products)
        ];
    }

    private function generateIndentsVsShipmentsData()
    {
        // Monthly indents vs shipments analysis
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('F');

            $totalIndents = rand(100, 150);
            $shippedOnTime = rand(85, 95);
            $delayedShipments = $totalIndents - $shippedOnTime;
            $onTimePercentage = $totalIndents > 0 ? ($shippedOnTime / $totalIndents) * 100 : 0;

            $months->push([
                'month' => $monthName,
                'total_indents' => $totalIndents,
                'shipped_on_time' => $shippedOnTime,
                'delayed_shipments' => $delayedShipments,
                'on_time_percentage' => round($onTimePercentage, 1)
            ]);
        }

        return [
            'monthly_data' => $months,
            'report_date' => now()->format('M d, Y'),
            'total_months' => $months->count()
        ];
    }

    private function generateCustomerBusinessVolumeData()
    {
        // Customer-wise business volume - Demo Data
        $customers = [
            [
                'customer_name' => 'Dhaka Medical College Hospital',
                'total_orders' => 125,
                'total_volume' => 8500,
                'total_revenue' => 1250000,
                'avg_lead_time' => 8
            ],
            [
                'customer_name' => 'Square Hospital',
                'total_orders' => 98,
                'total_volume' => 7200,
                'total_revenue' => 980000,
                'avg_lead_time' => 6
            ],
            [
                'customer_name' => 'Apollo Hospitals',
                'total_orders' => 156,
                'total_volume' => 11200,
                'total_revenue' => 1560000,
                'avg_lead_time' => 10
            ],
            [
                'customer_name' => 'United Hospital',
                'total_orders' => 87,
                'total_volume' => 6500,
                'total_revenue' => 870000,
                'avg_lead_time' => 7
            ],
            [
                'customer_name' => 'Popular Medical Centre',
                'total_orders' => 134,
                'total_volume' => 9200,
                'total_revenue' => 1340000,
                'avg_lead_time' => 9
            ],
            [
                'customer_name' => 'Labaid Hospital',
                'total_orders' => 112,
                'total_volume' => 7800,
                'total_revenue' => 1120000,
                'avg_lead_time' => 8
            ],
            [
                'customer_name' => 'Apex Pharmacy',
                'total_orders' => 89,
                'total_volume' => 6800,
                'total_revenue' => 890000,
                'avg_lead_time' => 5
            ],
            [
                'customer_name' => 'MedPlus Pharmacy',
                'total_orders' => 76,
                'total_volume' => 5400,
                'total_revenue' => 760000,
                'avg_lead_time' => 6
            ],
            [
                'customer_name' => 'Popular Diagnostic Centre',
                'total_orders' => 145,
                'total_volume' => 9800,
                'total_revenue' => 1450000,
                'avg_lead_time' => 11
            ],
            [
                'customer_name' => 'LabAid Diagnostic',
                'total_orders' => 103,
                'total_volume' => 7500,
                'total_revenue' => 1030000,
                'avg_lead_time' => 9
            ]
        ];

        return [
            'customers' => collect($customers)->sortByDesc('total_revenue'),
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'total_customers' => count($customers)
        ];
    }

    private function generateOutstandingPaymentsData()
    {
        // Outstanding payments by customer - Demo Data
        $customers = [
            [
                'customer_name' => 'Dhaka Medical College Hospital',
                'total_amount_billed' => 1250000,
                'amount_paid' => 1000000,
                'outstanding_amount' => 250000,
                'days_overdue' => 15
            ],
            [
                'customer_name' => 'Square Hospital',
                'total_amount_billed' => 980000,
                'amount_paid' => 850000,
                'outstanding_amount' => 130000,
                'days_overdue' => 8
            ],
            [
                'customer_name' => 'Apollo Hospitals',
                'total_amount_billed' => 1560000,
                'amount_paid' => 1200000,
                'outstanding_amount' => 360000,
                'days_overdue' => 22
            ],
            [
                'customer_name' => 'United Hospital',
                'total_amount_billed' => 870000,
                'amount_paid' => 750000,
                'outstanding_amount' => 120000,
                'days_overdue' => 12
            ],
            [
                'customer_name' => 'Popular Medical Centre',
                'total_amount_billed' => 1340000,
                'amount_paid' => 1100000,
                'outstanding_amount' => 240000,
                'days_overdue' => 18
            ],
            [
                'customer_name' => 'Labaid Hospital',
                'total_amount_billed' => 1120000,
                'amount_paid' => 950000,
                'outstanding_amount' => 170000,
                'days_overdue' => 10
            ],
            [
                'customer_name' => 'Apex Pharmacy',
                'total_amount_billed' => 890000,
                'amount_paid' => 800000,
                'outstanding_amount' => 90000,
                'days_overdue' => 5
            ],
            [
                'customer_name' => 'MedPlus Pharmacy',
                'total_amount_billed' => 760000,
                'amount_paid' => 650000,
                'outstanding_amount' => 110000,
                'days_overdue' => 14
            ],
            [
                'customer_name' => 'Popular Diagnostic Centre',
                'total_amount_billed' => 1450000,
                'amount_paid' => 1150000,
                'outstanding_amount' => 300000,
                'days_overdue' => 25
            ],
            [
                'customer_name' => 'LabAid Diagnostic',
                'total_amount_billed' => 1030000,
                'amount_paid' => 900000,
                'outstanding_amount' => 130000,
                'days_overdue' => 9
            ]
        ];

        return [
            'customers' => collect($customers)->sortByDesc('outstanding_amount'),
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'total_outstanding' => collect($customers)->sum('outstanding_amount')
        ];
    }

    private function generateLcExpiryAnalysisData()
    {
        // L/C expiry analysis - Demo Data
        $lcs = [
            [
                'lc_number' => 'LC-00001',
                'customer' => 'Dhaka Medical College Hospital',
                'principal' => 'Pfizer Inc',
                'amount' => 500000,
                'issue_date' => '15-Jan-24',
                'expiry_date' => '15-Mar-25',
                'days_remaining' => 45,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00002',
                'customer' => 'Square Hospital',
                'principal' => 'Novartis AG',
                'amount' => 750000,
                'issue_date' => '20-Feb-24',
                'expiry_date' => '20-Apr-25',
                'days_remaining' => 81,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00003',
                'customer' => 'Apollo Hospitals',
                'principal' => 'Johnson & Johnson',
                'amount' => 1200000,
                'issue_date' => '10-Mar-24',
                'expiry_date' => '10-Jun-25',
                'days_remaining' => 132,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00004',
                'customer' => 'United Hospital',
                'principal' => 'Roche Holding AG',
                'amount' => 850000,
                'issue_date' => '05-Apr-24',
                'expiry_date' => '05-Jul-25',
                'days_remaining' => 158,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00005',
                'customer' => 'Popular Medical Centre',
                'principal' => 'Merck & Co',
                'amount' => 650000,
                'issue_date' => '15-May-24',
                'expiry_date' => '15-Aug-25',
                'days_remaining' => 200,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00006',
                'customer' => 'Labaid Hospital',
                'principal' => 'Sun Pharmaceutical',
                'amount' => 950000,
                'issue_date' => '25-Jun-24',
                'expiry_date' => '25-Sep-25',
                'days_remaining' => 242,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00007',
                'customer' => 'Apex Pharmacy',
                'principal' => 'Dr. Reddy\'s Laboratories',
                'amount' => 450000,
                'issue_date' => '10-Jul-24',
                'expiry_date' => '10-Oct-25',
                'days_remaining' => 258,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00008',
                'customer' => 'MedPlus Pharmacy',
                'principal' => 'Cipla Ltd',
                'amount' => 380000,
                'issue_date' => '20-Aug-24',
                'expiry_date' => '20-Nov-25',
                'days_remaining' => 299,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00009',
                'customer' => 'Popular Diagnostic Centre',
                'principal' => 'Pfizer Inc',
                'amount' => 1100000,
                'issue_date' => '05-Sep-24',
                'expiry_date' => '05-Dec-25',
                'days_remaining' => 315,
                'status' => 'Active'
            ],
            [
                'lc_number' => 'LC-00010',
                'customer' => 'LabAid Diagnostic',
                'principal' => 'Novartis AG',
                'amount' => 720000,
                'issue_date' => '15-Oct-24',
                'expiry_date' => '15-Jan-26',
                'days_remaining' => 356,
                'status' => 'Active'
            ]
        ];

        return [
            'lcs' => collect($lcs)->sortBy('days_remaining'),
            'report_date' => now()->format('M d, Y'),
            'currency' => 'BDT',
            'total_lcs' => count($lcs),
            'active_lcs' => count($lcs),
            'expired_lcs' => 0
        ];
    }
}
